<?php


class Contacts
{
    const NUMBER_CONTACTS_PER_PAGE = 7;
    private $mysqli;
    public $id;
    public $name;
    public $phones;
    public $emails;

    private $contacts_table   = 'users';
    private $user_email_table = 'user_email';
    private $user_phone_table = 'user_phone';

    public function __construct($data = [])
    {
        $this->mysqli   = new mysqli("localhost", "root", "root", "contacts");;
        $this->id     = $data['id'];
        $this->name   = $data['name'];
        $this->emails = $data['emails'];
        $this->phones = $data['phones'];

        include_once __DIR__ . "/../../src/helpers/var_dumper.php";
    }

    public function save()
    {
        if ($this->id > 0) {
            $name_update_query = "UPDATE {$this->contacts_table} set `name` = '{$this->name}' where id = $this->id";
            $this->mysqli->query($name_update_query);

            $this->emails = explode(',', $this->emails);
            foreach ($this->emails as $email) {
                $exploded = explode('=>', $email);
                $id = $exploded[0];
                $email_body = $exploded[1];
                $query = "UPDATE {$this->user_email_table} set `email` = '$email_body' where id = $id";
                $this->mysqli->query($query);
            }
            $this->phones = explode(',', $this->phones);
            foreach ($this->phones as $phone) {
                $exploded = explode('=>', $phone);
                $id = $exploded[0];
                $number = $exploded[1];
                $query = "UPDATE {$this->user_phone_table} set `phone_number` = '$number' where id = $id";
                $this->mysqli->query($query);
            }
        } else {
            $query = "INSERT INTO {$this->contacts_table} ( `name` ) VALUES ('" . $this->name . "')";
            $this->mysqli->query($query);
            $id = $this->mysqli->insert_id;
            foreach ($_POST['emails'] as $email) {
                $this->mysqli->query("INSERT INTO {$this->user_email_table} (`user_id`, `email`) VALUES ($id, '$email')");
            }
            foreach ($_POST['phones'] as $phone) {
                $this->mysqli->query("INSERT INTO {$this->user_phone_table} (`user_id`, `phone_number`) VALUES ($id, '$phone')");
            }
        }

        header('location: /index.php');
    }

    public function all($limit = self::NUMBER_CONTACTS_PER_PAGE, $offset = 0, $conditions)
    {
        $query = "SELECT * from {$this->contacts_table}";
        if ($conditions) {
            $query .= " WHERE $conditions";
        }
        $query .= " ORDER by `name` limit $offset, $limit";
        $result = $this->mysqli->query($query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

        $query = "SELECT * from {$this->contacts_table}";
        $result =  $this->mysqli->query($query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function get_properties($user_id)
    {
        return $this->get_data($user_id);
    }

    public function getById($user_id)
    {
        $user = $this->mysqli->query("select * from {$this->contacts_table} where id = $user_id");
        $one = mysqli_fetch_all($user, MYSQLI_ASSOC);

        $result = $this->get_data($user_id);
        $result['user'] = $one[0];

        return $result;
    }

    public function deleteById($id)
    {
        $this->mysqli->query("delete from {$this->contacts_table} where id = $id");
    }

    private function get_data($user_id = null)
    {
        $emails_query = "SELECT user_email.id as id, users.id as user_id, user_email.email as email
            FROM {$this->contacts_table}
            LEFT JOIN user_email on users.id = user_email.user_id";

        $phone_number_query = "SELECT user_phone.id as id, users.id as user_id, user_phone.phone_number as phone_number
            FROM {$this->contacts_table}
            LEFT JOIN user_phone on users.id = user_phone.user_id";
        if ($user_id) {
            $emails_query       .= " WHERE user_id = $user_id";
            $phone_number_query .= " WHERE user_id = $user_id";
        }

        $emails_query_result = $this->mysqli->query($emails_query);
        $emails = mysqli_fetch_all($emails_query_result, MYSQLI_ASSOC);

        $phone_number_result = $this->mysqli->query($phone_number_query);
        $phone_numbers = mysqli_fetch_all($phone_number_result, MYSQLI_ASSOC);

        return ['emails' => $emails, 'phone_numbers' => $phone_numbers];
    }
}