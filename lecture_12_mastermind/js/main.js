(function() {

    $(document).ready(function () {

        // обработчик клика "Угадать" - извлекаем текущее значение
        // догадки пользователя и отправляем его на сервер
        $('#submitGuess').click(function(e) {
            var $input = $('input#guessVal'),
                $output = $('div#output'),
                val = $input.val().trim();
            $.post({
                url     : 'index.php?_R=game/guess',
                data    : { guess : val },
                success : function (data) {
                    var $html = $(data);
                    if ($html.hasClass('success'))
                        $input.val('');
                    if ($html.hasClass('first'))
                        $output.html('');
                    $output.append($html);
                }
            });
        });

        // получаем и заполняем текущее состояние игры
        $.get({
            url     : 'index.php?_R=game/history',
            success : function (data) {
                $('div#output').append(data);
            }
        });

    });

})();