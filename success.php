<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(!empty($_GET['pixel'])){?> 
        <img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=<?php echo $_GET['pixel'];?>&ev=Lead&noscript=1"/>
        <?php }?>
          <meta name="referrer" content="no-referrer">
          <!--Add-->
            <?php if ($pixel) { ?>
            <!-- Facebook Pixel Code -->
           <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo $pixel; ?>');
            fbq('track', 'PageView');
            fbq('track', 'Lead');
          </script>
          <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=<?php echo $pixel; ?>&ev=Lead&noscript=1"
          /></noscript>
          <!-- End Facebook Pixel Code -->
            <?php } ?>
            <meta name="referrer" content="no-referrer">
        <!--/Add-->
    <title>Gracias!</title>
    <style>
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e6f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        
        #header {
            font-size: 28px;
            margin-bottom: 20px;
            color: #003366;
        }

        #image {
            max-width: 450px;
            margin: 20px 0;
        }

        #message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }

        #download-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .download-button {
            margin: 10px;
            padding: 15px 30px;
            background-color: #003366;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }

        .download-button:hover {
            background-color: #0055a5;
        }

        @media (width < 408px) {
            body{
                width: 90%;
                margin: 0 auto;
                display: block;
                height: 120vh;
                align-items: center;
                text-align: center;
            }
            #header {
                font-size: 35px;
            }

            #message {
                font-size: 16px;
            }

            .download-button {
                padding: 22px 34px;
                font-size: 16px;
            }
            #image{
                width: 350px;
                display: block;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
        <div id="header">Gracias!</div>
        <img id="image" src="./templates/success_page/free.png" alt="Картинка">
        <div id="message">
        Gracias por elegir nuestro programa! Procesaremos su solicitud. 
            Mientras tanto, se puede descargar de forma gratuita:
        </div>
        <div id="download-buttons">
            <a class="download-button" href="diary.pdf" download>Descargar diario de diabetes</a>
            <a class="download-button" href="article.pdf" download>Descargar un artículo especial</a>
        </div>
</body>
</html>
