<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso Denegado | Tienda en Línea</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
      display: flex; align-items: center; justify-content: center;
    }
    .error-card {
      border: none; border-radius: 18px;
      box-shadow: 0 20px 60px rgba(0,0,0,.5);
      max-width: 420px; width: 100%;
      overflow: hidden;
    }
    .error-header {
      background: linear-gradient(135deg,#e94560,#c62a47);
      padding: 30px 20px 20px; text-align: center;
    }
    .error-icon { font-size: 4rem; color: #fff; }
    .error-header h2 { color: #fff; font-weight: 700; margin: 10px 0 4px; }
    .error-header p { color: rgba(255,255,255,.8); margin: 0; font-size: .9rem; }
    .card-body { padding: 30px; text-align: center; }
    .card-body p { color: #555; }
    .btn-back {
      background: linear-gradient(135deg,#e94560,#c62a47);
      border: none; border-radius: 10px;
      padding: 10px 30px; color: #fff; font-weight: 600;
      transition: opacity .2s;
    }
    .btn-back:hover { opacity: .85; color: #fff; }
  </style>
</head>
<body>
  <div class="card error-card">
    <div class="error-header">
      <div class="error-icon"><i class="bi bi-shield-x"></i></div>
      <h2>Acceso Denegado</h2>
      <p>Credenciales inválidas</p>
    </div>
    <div class="card-body">
      <p class="mb-4">El <strong>usuario</strong> o la <strong>contraseña</strong> ingresados no son correctos.<br>
        Por favor verifica tus datos e intenta de nuevo.</p>
      <a href="index.php" class="btn btn-back">
        <i class="bi bi-arrow-left-circle me-2"></i>Volver al Inicio de Sesión
      </a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
