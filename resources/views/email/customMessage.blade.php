<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Confirmation</title>
</head>
<body style="background: linear-gradient(135.00deg, rgb(225, 250, 74) 0%,rgb(204, 74, 250) 100%); background-repeat: no-repeat;">
  <div class="confirmation-container" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
    <h2 class="confirmation-title" style="text-align: center;">Подтверждение адреса электронной почты</h2>
    <p>Здравствуйте,</p>
    <p>Вы получили это письмо, потому что зарегистрировались на нашем сайте. Пожалуйста, введите следующий код для подтверждения вашего адреса электронной почты:</p>
    <h1 class="confirmation-code" style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 20px; margin-bottom: 40px;">{{ $code }}</h1>
    <span>Никому не пересылайте письмо. Если вы получили код по ошибке проигнорируйте его.</span>
    <span style="margin-top: 10px;">С уважением,<br>Команда сайта</span>
  </div>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Confirmation</title>
</head>
<body style="margin: 0; padding: 0; background: linear-gradient(135.00deg, rgb(225, 250, 74) 0%,rgb(204, 74, 250) 100%); background-repeat: no-repeat;">
  <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <tr>
      <td style="padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
        <h2 style="text-align: center; margin: 0;">Подтверждение адреса электронной почты</h2>
        <p style="margin: 10px 0;">Здравствуйте,</p>
        <p style="margin: 10px 0;">Вы получили это письмо, потому что зарегистрировались на нашем сайте. Пожалуйста, введите следующий код для подтверждения вашего адреса электронной почты:</p>
        <h1 style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 20px; margin-bottom: 40px;">{{ $code }}</h1>
        <p style="margin: 10px 0;">Никому не пересылайте письмо. Если вы получили код по ошибке проигнорируйте его.</p>
        <p style="margin: 10px 0;">С уважением,<br>Команда сайта</p>
      </td>
    </tr>
  </table>
</body>
</html>
