<?php
session_start();

// Proteger la página: solo administradores
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'administrador') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard – Administrador | Tienda en Línea</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <style>
    body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
    .navbar { background: linear-gradient(135deg, #1a1a2e, #0f3460); }
    .navbar-brand { font-weight: 700; color: #fff !important; font-size: 1.2rem; }
    .navbar-text { color: rgba(255,255,255,.8) !important; }
    .stat-card {
      border: none; border-radius: 14px;
      color: #fff; padding: 22px;
      box-shadow: 0 4px 15px rgba(0,0,0,.12);
    }
    .stat-card.ventas   { background: linear-gradient(135deg,#e94560,#c62a47); }
    .stat-card.products { background: linear-gradient(135deg,#0f3460,#16213e); }
    .stat-card.clientes { background: linear-gradient(135deg,#533483,#3a2469); }
    .stat-card .icon { font-size: 2.2rem; opacity: .8; }
    .stat-card h4 { font-size: 2rem; font-weight: 700; margin: 6px 0 2px; }
    .stat-card p  { font-size: .85rem; opacity: .85; margin: 0; }
    .chart-card { border: none; border-radius: 14px; box-shadow: 0 4px 15px rgba(0,0,0,.08); }
    .chart-card .card-header {
      background: #fff; border-bottom: 1px solid #eee;
      border-radius: 14px 14px 0 0; font-weight: 600; color: #333;
    }
    footer { color: #999; font-size: .82rem; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg px-4">
  <span class="navbar-brand"><i class="bi bi-shop me-2"></i>Tienda en Línea</span>
  <div class="ms-auto d-flex align-items-center gap-3">
    <span class="navbar-text">
      <i class="bi bi-person-circle me-1"></i>
      <?= htmlspecialchars($_SESSION['usuario']) ?>
      <span class="badge bg-warning text-dark ms-1">Administrador</span>
    </span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">
      <i class="bi bi-box-arrow-right me-1"></i>Salir
    </a>
  </div>
</nav>

<div class="container-fluid py-4 px-4">

  <h5 class="mb-4 text-secondary"><i class="bi bi-speedometer2 me-2"></i>Panel de Control</h5>

  <!-- Tarjetas resumen -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
      <div class="stat-card ventas">
        <div class="icon"><i class="bi bi-currency-dollar"></i></div>
        <h4>$34,820</h4>
        <p>Ventas del mes</p>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="stat-card products">
        <div class="icon"><i class="bi bi-box-seam"></i></div>
        <h4>5</h4>
        <p>Productos en catálogo</p>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="stat-card clientes">
        <div class="icon"><i class="bi bi-people-fill"></i></div>
        <h4>80</h4>
        <p>Clientes registrados</p>
      </div>
    </div>
  </div>

  <!-- Gráficas -->
  <div class="row g-4">
    <!-- Ventas mensuales - Barra -->
    <div class="col-lg-7">
      <div class="card chart-card">
        <div class="card-header py-3">
          <i class="bi bi-bar-chart-fill me-2 text-danger"></i>Ventas Mensuales
        </div>
        <div class="card-body">
          <canvas id="ventasChart" height="260"></canvas>
        </div>
      </div>
    </div>

    <!-- Distribución por producto - Dona -->
    <div class="col-lg-5">
      <div class="card chart-card">
        <div class="card-header py-3">
          <i class="bi bi-pie-chart-fill me-2 text-primary"></i>Ventas por Producto
        </div>
        <div class="card-body">
          <canvas id="productoChart" height="260"></canvas>
        </div>
      </div>
    </div>

    <!-- Stock por producto - Línea -->
    <div class="col-12">
      <div class="card chart-card">
        <div class="card-header py-3">
          <i class="bi bi-graph-up me-2 text-success"></i>Existencias por Producto
        </div>
        <div class="card-body">
          <canvas id="stockChart" height="120"></canvas>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center mt-4">
    &copy; <?= date('Y') ?> Tienda en Línea – Panel Administrativo
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Gráfica 1: Ventas mensuales ──────────────────────────────────
const ctxVentas = document.getElementById('ventasChart').getContext('2d');
new Chart(ctxVentas, {
  type: 'bar',
  data: {
    labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep'],
    datasets: [{
      label: 'Ventas ($)',
      data: [12000, 18500, 15000, 22000, 19000, 27000, 25000, 30000, 34820],
      backgroundColor: 'rgba(233,69,96,0.75)',
      borderColor: '#e94560',
      borderWidth: 2,
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
      x: { grid: { display: false } }
    }
  }
});

// ── Gráfica 2: Ventas por producto (dona) ───────────────────────
const ctxProducto = document.getElementById('productoChart').getContext('2d');
new Chart(ctxProducto, {
  type: 'doughnut',
  data: {
    labels: ['Audífonos','Smartwatch','Teclado','Bocina','Mouse'],
    datasets: [{
      data: [35, 25, 18, 12, 10],
      backgroundColor: ['#e94560','#0f3460','#533483','#f5a623','#2ecc71'],
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'bottom' } }
  }
});

// ── Gráfica 3: Stock actual ──────────────────────────────────────
const ctxStock = document.getElementById('stockChart').getContext('2d');
new Chart(ctxStock, {
  type: 'line',
  data: {
    labels: ['Audífonos','Smartwatch','Teclado','Bocina','Mouse'],
    datasets: [{
      label: 'Existencias',
      data: [15, 8, 20, 12, 25],
      borderColor: '#0f3460',
      backgroundColor: 'rgba(15,52,96,0.12)',
      pointBackgroundColor: '#e94560',
      pointRadius: 6,
      tension: 0.4,
      fill: true
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
      x: { grid: { display: false } }
    }
  }
});
</script>
</body>
</html>
