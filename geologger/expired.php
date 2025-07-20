<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Link Expired</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      max-width: 500px;
      margin: 60px auto;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    .countdown {
      font-size: 1.2rem;
      margin-top: 10px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="card text-center">
    <h1 class="text-danger"><i class="fa-solid fa-clock"></i> Link Expired</h1>
    <p class="lead">This tracking link is no longer active due to expiration or a click limit.</p>
    <p class="countdown">You’ll be redirected in <span id="countdown">6</span> seconds...</p>
    <a class="btn btn-primary mt-3" href="../create.php">
      <i class="fa-solid fa-plus"></i> Generate a New Link
    </a>
  </div>

  <script>
    let seconds = 6;
    const countdownEl = document.getElementById("countdown");

    const timer = setInterval(() => {
      seconds--;
      countdownEl.textContent = seconds;

      if (seconds <= 0) {
        document.querySelector('.card').style.opacity = '0.5';
        clearInterval(timer);
        window.location.href = "../create.php";
      }
    }, 1000);
  </script>
</body>
</html>
