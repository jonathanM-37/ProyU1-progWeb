<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda en Línea – Iniciar Sesión</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-login {
      border: none;
      border-radius: 18px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.5);
      width: 100%;
      max-width: 420px;
    }
    .card-login .card-header {
      background: linear-gradient(135deg, #e94560, #0f3460);
      border-radius: 18px 18px 0 0;
      padding: 30px 20px 20px;
      text-align: center;
    }
    .card-login .card-header h2 {
      color: #fff;
      font-weight: 700;
      font-size: 1.6rem;
      margin: 0;
    }
    .card-login .card-header p {
      color: rgba(255,255,255,0.75);
      margin: 4px 0 0;
      font-size: 0.9rem;
    }
    .card-body { padding: 35px 30px; }
    .form-label { font-weight: 600; color: #333; }
    .btn-login {
      background: linear-gradient(135deg, #e94560, #c62a47);
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      transition: opacity .2s;
    }
    .btn-login:hover { opacity: .88; }
    .input-group-text { background: #f8f9fa; }
  </style>
</head>
<body>
  <div class="card card-login">
    <div class="card-header">
      <h2><i class="bi bi-shop"></i> Tienda en Línea</h2>
      <p>Ingresa tus credenciales para continuar</p>
    </div>
    <div class="card-body">
      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="usuario" name="usuario"
                   placeholder="Ingresa tu usuario" required autofocus>
          </div>
        </div>
        <div class="mb-4">
          <label for="contrasena" class="form-label">Contraseña</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" id="contrasena" name="contrasena"
                   placeholder="Ingresa tu contraseña" required>
          </div>
        </div>
        <button type="submit" class="btn btn-login btn-danger w-100">
          <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
