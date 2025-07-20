<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Link Usage Limit Reached</title>
  <link rel="stylesheet" href="../assets/style.css">
  <meta http-equiv="refresh" content="6;url=../create.php">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 2rem;
      text-align: center;
    }
    .card {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 500px;
      margin: auto;
    }
    h1 {
      color: #cc6600;
      font-size: 1.6rem;
      margin-bottom: 1rem;
    }
    p {
      color: #333;
      font-size: 1rem;
      margin-bottom: 1rem;
    }
    .button {
      display: inline-block;
      background-color: #0066cc;
      color: white;
      padding: 0.7rem 1.2rem;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .button:hover {
      background-color: #004a99;
    }
    @media (max-width: 600px) {
      body { padding: 1rem; }
      .card { padding: 1.5rem; }
      h1 { font-size: 1.4rem; }
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>?? Link usage limit reached</h1>
    <p>This tracking link has already been clicked the maximum number of times allowed.</p>
    <p>You’ll be redirected in <span id="countdown">6</span> seconds.</p>
    <a class="button" href="../create.php">?? Generate a new link</a>
  </div>

  <script>
    let seconds = 6;
    const countdown = document.getElementById("countdown");
    const interval = setInterval(() => {
      seconds--;
      countdown.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(interval);
        window.location.href = "../create.php";
      }
    }, 1000);
  </script>
</body>
</html>
