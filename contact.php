<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kontaktseite</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #121212; /* Dunkler Hintergrund */
    color: #ffffff; /* Heller Text */
    padding: 20px;
  }

  .contact-form {
    background-color: #1e1e1e; /* Etwas helleres Dunkel */
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    max-width: 600px;
    margin: 0 auto;
  }

  .contact-form h2 {
    margin-bottom: 20px;
    color: #ffffff; /* Weißes H2 */
  }

  .contact-form label {
    display: block;
    margin-bottom: 10px;
    color: #cccccc; /* Helle Schrift */
  }

  .contact-form input,
  .contact-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #555555; /* Graue Umrandung */
    border-radius: 5px;
    margin-bottom: 20px;
    background-color: #2b2b2b; /* Dunkleres Grau */
    color: #ffffff; /* Weißer Text */
  }

  .contact-form button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #3a3a3a; /* Dunkleres Grau */
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .contact-form button:hover {
    background-color: #555555; /* Helleres Grau beim Hover */
  }

  .error {
    color: red; /* Rote Fehlermeldung */
    font-weight: bold;
    display: none;
  }
</style>
</head>
<body>

<div class="contact-form">
  <h2>Kontaktieren Sie uns</h2>
  <form id="contactForm" onsubmit="return validateForm()">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Ihr Name" required>
    
    <label for="email">E-Mail:</label>
    <input type="email id="email" name="email" placeholder="Ihre E-Mail-Adresse" required>
    
    <label for="subject">Betreff:</label>
    <input type="text" id="subject" name="subject" placeholder="Betreff" required>
    
    <label for="message">Nachricht:</label>
    <textarea id="message" name="message" placeholder="Ihre Nachricht" rows="6" required></textarea>
    
    <button type="submit">Senden</button>
  </form>

  <div id="formError" class="error">Bitte füllen Sie alle Felder aus.</div>
</div>

<script>
function validateForm() {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var subject = document.getElementById("subject").value;
  var message = document.getElementById("message").value;
  
  if (name === "" || email === "" || subject === "" oder message === "") {
    document.getElementById("formError").style.display = "block";
    return false;
  }

  document.getElementById("formError").style.display = "none";
  return true;
}
</script>

</body>
</html>
