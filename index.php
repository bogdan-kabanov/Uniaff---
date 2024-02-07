
<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" /> 
  <link rel="stylesheet" href="./assets/css/style.css" />
   <style>
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .pulse-button {
            animation: pulse 2s infinite;
        }
    </style>
    <script>
      var date = new Date();
      date.setTime(date.getTime() + (5 * 24 * 60 * 60 * 1000));
      if (!'{pixel}'.match('{')) {
         document.cookie = "pixel={pixel}; " + "expires=" + date.toUTCString() + "";
      }
   </script>
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>
<body>
  <main> 
    <section class="head">
      <div class="container">
        <div class="row">
          <div class="col-12"> 
            <h2>Encuesta social sobre: 'La importancia de un estilo de vida saludable'</h2>

          </div>
        </div>
      </div>
    </section>
    <section class="questions mt-5 pt-5">
      <div class="container">
        <div class="row">
          <div class="col-12">
            
            <h2 class="mb-3" style="background: #0D9276; border-radius: 5px; padding: 10px 15px; color: white;">Bloque de salud</h2>
            
            <?php 
              include('./templates/question/question_section.php'); 
              $questionNumbersBlock1 = [21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40];
              displayQuestions($questionNumbersBlock1);
            ?>
           
            <h2 class="mb-3" style="background: #0D9276; border-radius: 5px; padding: 10px 15px; color: white;">Bloque de información</h2>
            
            <?php 
              $questionNumbersBlock2 = [41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54];
              displayQuestions($questionNumbersBlock2);
            ?>
            <!-- Добавьте другие блоки с вопросами, если необходимо -->
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-12">
            <div class="d-flex justify-content-center">
              <a href="success.php?pixel=<?php echo $_GET['pixel'] ?>" class="btn btn-primary btn-lg pulse-button">Obtener un regalo</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>

    const _domain = "https://analcustdev.com" 

    function submitAnswer(questionId) {
      const textarea = document.getElementById(`answer-${questionId}`);
      const responseText = textarea.value;

      if (responseText.trim() === "") {
        alert("Por favor, ingrese una respuesta.");
        return;
      }

      const localStorageKey = `answered-${questionId}`;
      if (localStorage.getItem(localStorageKey)) {
        alert("Ya has enviado una respuesta a esta pregunta.");
        return;
      }

      const data = {
        question_id: questionId,
        response_text: responseText
      };

      fetch(_domain + '/api/handwrittenAnswer/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(response => {
        if (response.ok) {
            alert("¡Respuesta enviada exitosamente!");
            textarea.value = ""; // Limpiar el área de texto después de enviar
            localStorage.setItem(localStorageKey, true); // Establecer una bandera en el almacenamiento local
        } else {
            alert("Se produjo un error al enviar la respuesta");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Se produjo un error al enviar la respuesta");
    });

    }

    function displayQuestions(questionNumbers) {
      questionNumbers.forEach(function(questionNumber) {
        // Формируем URL-адрес для запроса на вопрос
        const questionUrl = _domain + `/api/question/get/${questionNumber}`;

        // Выполняем GET-запрос на вопрос
        fetch(questionUrl)
          .then(response => response.json())
          .then(questionData => {
            if (questionData && questionData.question && questionData.question.name) {
              const questionId = questionData.question.id;
              const localStorageKey = `answered-${questionId}`;

              const questionsContainer = document.querySelector('.questions');
              const questionDiv = document.createElement('div');
            questionDiv.innerHTML = `
                <h3>${questionData.question.name}</h3>
                <span>Ingrese una respuesta</span>
                <div class='answers answers-question-${questionId}'>
                    <textarea id='answer-${questionId}' rows='4' cols='50'></textarea>
                    <button onclick='submitAnswer(${questionId})'>Enviar respuesta</button>
                </div>
            `;


              // Проверяем, был ли ответ уже отправлен
              if (localStorage.getItem(localStorageKey)) {
                const alreadyAnsweredMessage = document.createElement('p');
                alreadyAnsweredMessage.textContent = "Ya has enviado una respuesta a esta pregunta.";
                questionDiv.appendChild(alreadyAnsweredMessage);
              }

              questionsContainer.appendChild(questionDiv);
            } else {
              console.error(`La pregunta no se encuentra para el número ${questionNumber}`);
            }
          })
          .catch(error => {
            console.error(`Error al ejecutar la solicitud de la pregunta ${questionNumber}: ${error}`);
          });
      });
    }
  </script>
</body>
</html>
