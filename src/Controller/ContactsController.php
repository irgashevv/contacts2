<?php

include_once __DIR__ . "/../Model/Contacts.php";

class ContactsController
{
    private $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect('localhost', 'root', 'root', 'contacts');
        include_once __DIR__ . "/../../src/helpers/var_dumper.php";
    }

    public function create()
    {
        include_once __DIR__ . "/../../views/contacts/form.php";
    }

    public function read()
    {
        $limit  = intval($_GET['limit'] ?? Contacts::NUMBER_CONTACTS_PER_PAGE);
        $offset = (intval($_GET['page'] ?? 1) - 1) * $limit;
        $offset = $offset < 0 ? 0 : $offset;
        $query  = '';
        if (isset($_GET['search'])) {
            $searchQ = $_GET['search'];
            $query .=  " `name` LIKE '%$searchQ%'";
        }

        $all = (new Contacts())->all($limit, $offset, $query);

        include_once __DIR__ . "/../../src/helpers/var_dumper.php";
        include_once __DIR__ . "/../../views/contacts/list.php";
    }

    public function update()
    {
        $id = (int) $_GET['id'];

        if (empty($id)) die('Undefined ID');

        $result = (new Contacts())->getById($id);

        if (empty($result)) die('Contact not found');

        include_once __DIR__ . "/../../views/contacts/form.php";
    }

    public function delete()
    {
        $id = (int) $_GET['id'];
        (new Contacts())->deleteById($id);

        return $this->read();
    }

    public function save()
    {
        if (!empty($_POST))
        {
            $user_data = [
                'id'     => $_POST['id'],
                'name'   => $_POST['name'],
                'emails' => $_POST['emails_value'],
                'phones' => $_POST['phones_value'],
            ];
            $contacts = new Contacts($user_data);
            $contacts->save();
        }
        return $this->read();
    }

}