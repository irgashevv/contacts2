<?php
include_once __DIR__ . "/../header.php";

$url = $_SERVER['REQUEST_URI'];
if ($_GET['action'] == 'create')
    $header = 'Добавить новый контакт';
else {
    $header = 'Изменить данные контакта';
}
?>

    <div class="form-div">
        <h1 class="display-4 text-center mt-5"> <?= $header ?> </h1>
        <form class="form-horizontal w-50 container border border-info rounded " action="/?model=contacts&action=save"
              method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="emails_value">
            <input type="hidden" name="phones_value">
            <div class="card-body">
                <input type="hidden" value="<?= $result['user']['id'] ?? '' ?>" name="id">
                <div class="form-group">
                    <label class="font-weight-bold">Имя</label>
                    <input type="text" value="<?= $result['user']['name'] ?? '' ?>" name="name" class="form-control"
                           required
                           placeholder="Введите Ваше Имя" maxlength="30" minlength="4">
                </div>
                <label class="font-weight-bold">Номер телефона</label>
                <?php if ($_GET['action'] !== 'create'): ?>
                    <?php foreach ($result['phone_numbers'] as $key => $number): ?>
                        <?php
                            $phone_value = $number['phone_number'] ? "{$number['id']}" : '';
                        ?>
                        <div class="form-group d-flex">
                            <input type="hidden" value="<?=$phone_value?>" name="phones[]">
                            <input type="text" name="input_phones[]" value="<?= $number['phone_number'] ?? '' ?>"
                                   class="form-control" <?= $key == 0 ? 'required' : '' ?>
                                   placeholder="Введите Ваш номер телефона">
                            <?php if ($key == 0): ?>
<!--                                <button class="btn btn-primary ml-2" type="button" id="plus_phone">+-->
<!--                                </button>-->
                            <?php endif; ?>
                        </div>
                    <? endforeach; ?>
                <?php else: ?>
                    <div class="form-group d-flex">
                        <input type="text" name="phones[]" class="form-control"
                               placeholder="Номер">
                        <button class="btn btn-primary ml-2" type="button" id="plus_phone">+
                        </button>
                    </div>
                <?php endif; ?>

                <div id="phones_input" class="form-group"></div>
                <label class="font-weight-bold">Адреса электронной почты</label>
                <?php if ($_GET['action'] !== 'create'): ?>
                    <?php foreach ($result['emails'] as $key => $email) : ?>
                        <?php
                            $email_value = $email['email'] ? "{$email['id']}" : '';
                        ?>
                        <div class="form-group d-flex">
                            <input type="hidden" value="<?=$email_value?>" name="emails[]">
                            <input type="email" value="<?= $email['email'] ?? '' ?>"
                                   name="input_emails[]"
                                   class="form-control"
                                   required
                                   placeholder="Введите адрес электронной почты">
                            <?php if ($key == 0): ?>
<!--                                <button class="btn btn-primary ml-2" type="button" id="plus_email">+-->
<!--                                </button>-->
                            <?php endif; ?>
                        </div>
                    <? endforeach; ?>
                <?php else: ?>
                    <div class="form-group d-flex">
                        <input type="email" name="emails[]" class="form-control"
                               placeholder="Введите адрес электронной почты">
                        <button class="btn btn-primary ml-2" type="button" id="plus_email">+
                        </button>
                    </div>
                <?php endif; ?>
                <div id="emails_input" class="form-group"></div>
                <div>
                    <input type="submit" class="btn btn-info btn-save" id="submit" value="Сохранить">
                </div>
            </div>
        </form>
    </div>
<?php
include_once __DIR__ . "/../footer.php";
?>