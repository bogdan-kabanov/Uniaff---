# Документация по проклам

## Тип: Опросник

- Данныйй вид прокл представляет из себя
  - n-количество вопросов
  - полей ввода под каждым вопросом
  - кнопок для отправки содержимого из поля ввода **( на текущий вопрос )**

---

#### Пункт 1.1

Вопросы выводяться с помощью PHP кода в файл index.php в корне проекта

```
...
 <?php 
        include('./templates/question/question_section.php'); 
        $questionNumbersBlock1 = [1, 2, 3];
	displayQuestions($questionNumbersBlock1);
?>
...
```

В данном примере с помощью оператора **include** мы импортируем файл отвечающий за обработку запроса на сервер ( смотреть пункт 1.2)

Следующая строка это переменная **$questionNumbersBlock1** в неё мы передаём **id** вопросов которые хотим отобразить в данном блоке

И последняя строка отвечает за отправку массива из чисел ( id вопросов ) в код импртируемый выше

---

##### Пункт 1.2

##### Код из дирректории **./templates/question/question_section.php**

```
php
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
```
