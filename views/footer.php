<script src="../dist/js/jquery.min.js"></script>
<script src="../dist/js/popper.min.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../dist/js/app.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 10;
        var x = 1;

        $('#plus_email').on('click', () => {
            if (x < max_fields) {
                x++;
                $('#emails_input').append('<div class="d-flex mt-2"><input type="text" name="emails[]" class="form-control"/>' +
                    '<a href="#" class="delete btn btn-danger ml-2">-</a></div>')
            } else {
                alert('You Reached the limits')
            }
        });
        $('#emails_input').on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        $('#plus_phone').on('click', () => {
            if (x < max_fields) {
                x++;
                $('#phones_input').append('<div class="d-flex mt-2"><input type="text" name="phones[]" class="form-control"/>' +
                    '<a href="#" class="delete btn btn-danger ml-2">-</a></div>')
            } else {
                alert('You Reached the limits')
            }
        });
        $('#phones_input').on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        $('#submit').on('click', () => {
            var input_emails = $("input[name='input_emails[]']")
                .map(function(){
                    return $(this).val();
                }).get();
            var input_phones = $("input[name='input_phones[]']")
                .map(function(){
                    return $(this).val();
                }).get();

            var emails = $("input[name='emails[]']")
                .map(function(index, item){
                    let id = $(this).val();
                    let email = input_emails[index];
                    if (!email) {
                        let emailll = $('emails[' + index + "]").val()
                        return $('emails[index]')
                    }
                    if (input_emails[index]) {
                        // return "{'id:'" + id + "'phone:'" + email + "}";
                        return id + " => " + email;
                    }
                }).get();

            var phones = $("input[name='phones[]']")
                .map(function(index){
                    let id = $(this).val();
                    let phone = input_phones[index];
                    if (!phone) {
                        return "[" + phone + "]"
                    }
                    if (input_emails[index]) {
                        // return "{'id:'" + id + "'phone:'" + email + "}";
                        return id + " => " + phone;
                    }

                }).get();

            $("input[name='phones_value']").val(phones);
            $("input[name='emails_value']").val(emails);
        });
    })
</script>
</body>
</html>