<?php

function displayQuestions($questionNumbers) {
    // Формируем массив id вопросов для запроса
    $requestData = array("ids" => $questionNumbers);
    $requestDataJson = json_encode($requestData);

    // Устанавливаем параметры для HTTP-запроса
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n",
            'method' => 'GET',
            'content' => $requestDataJson,
        ),
    );

    // Создаем контекст для HTTP-запроса
    $context = stream_context_create($options);

    // Выполняем POST-запрос к новому эндпоинту
    $questionResponse = file_get_contents('https://analcustdev.com/api/question/get-multiple', false, $context);

    // Если запрос выполнен успешно и получен ответ
    if ($questionResponse !== false) {
        $questionData = json_decode($questionResponse, true);

        // Проверяем наличие вопросов в ответе
        if (isset($questionData['questionList']) && is_array($questionData['questionList'])) {
            foreach ($questionData['questionList'] as $question) {
                echo "<h3>{$question['name']}</h3>";
                echo "<span>Ingrese una respuesta</span>";
                echo "<div class='answers answers-question-{$question['id']}'>";
                echo "<textarea id='answer-{$question['id']}' rows='4' cols='50'></textarea>"; // Agregamos un textarea
                echo "<button onclick='submitAnswer({$question['id']})'>Enviar respuesta</button>"; // Agregamos un botón
                echo "</div>";
            }
        } else {
            // Обрабатываем случай, если список вопросов пуст
            echo "Список вопросов пуст.";
        }
    } else {
        // Обрабатываем ошибку, если запрос на вопрос не удался
        echo "Ошибка при выполнении запроса на вопросы.";
    }
}
?>