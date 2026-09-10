<?php
session_start();

// Proteger la página: solo clientes
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'cliente') {
    header('Location: index.php');
    exit;
}

// ── Productos de ejemplo ─────────────────────────────────────────
$productos = [
    [
        'nombre'      => 'Audífonos Bluetooth Pro',
        'precio'      => 599.00,
        'existencias' => 15,
        'imagen'      => 'img/audifonos.jpg',
        'descripcion' => 'Sonido envolvente, batería de 30 h y diadema acolchada.',
    ],
    [
        'nombre'      => 'Smartwatch Serie 5',
        'precio'      => 1299.00,
        'existencias' => 8,
        'imagen'      => 'img/smartwatch.jpg',
        'descripcion' => 'Monitor de salud, GPS integrado y resistente al agua.',
    ],
    [
        'nombre'      => 'Teclado Mecánico RGB',
        'precio'      => 899.00,
        'existencias' => 20,
        'imagen'      => 'img/teclado.jpg',
        'descripcion' => 'Switches táctiles, retroiluminación RGB y formato compacto.',
    ],
    [
        'nombre'      => 'Bocina Portátil 360°',
        'precio'      => 450.00,
        'existencias' => 12,
        'imagen'      => 'img/bocina.jpg',
        'descripcion' => 'Sonido 360°, resistente al agua y 12 h de batería.',
    ],
    [
        'nombre'      => 'Mouse Gaming 16000 DPI',
        'precio'      => 350.00,
        'existencias' => 25,
        'imagen'      => 'img/mouse.jpg',
        'descripcion' => 'Sensor de alta precisión, 7 botones programables y luz RGB.',
    ],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Productos | Tienda en Línea</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
    .navbar { background: linear-gradient(135deg, #1a1a2e, #0f3460); }
    .navbar-brand { font-weight: 700; color: #fff !important; }
    .navbar-text  { color: rgba(255,255,255,.8) !important; }

    .product-card {
      border: none; border-radius: 14px;
      box-shadow: 0 4px 18px rgba(0,0,0,.09);
      transition: transform .2s, box-shadow .2s;
      overflow: hidden;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,.15);
    }
    .product-card img {
      height: 200px; object-fit: cover; width: 100%;
      background: #e9ecef;
    }
    .img-placeholder {
      height: 200px; width: 100%;
      background: linear-gradient(135deg,#e9ecef,#dee2e6);
      display: flex; align-items: center; justify-content: center;
      font-size: 4rem; color: #adb5bd;
    }
    .badge-stock-ok  { background: #d4edda; color: #155724; }
    .badge-stock-low { background: #fff3cd; color: #856404; }
    .price { font-size: 1.3rem; font-weight: 700; color: #e94560; }
    .btn-add {
      background: linear-gradient(135deg,#e94560,#c62a47);
      border: none; color: #fff; border-radius: 8px;
      font-weight: 600; transition: opacity .2s;
    }
    .btn-add:hover { opacity: .85; color: #fff; }

    /* Carrito flotante */
    #carrito-badge {
      position: fixed; top: 18px; right: 80px; z-index: 1050;
    }
    #cart-panel {
      position: fixed; top: 0; right: -380px; width: 370px; height: 100vh;
      background: #fff; box-shadow: -4px 0 20px rgba(0,0,0,.15);
      z-index: 2000; transition: right .3s ease;
      overflow-y: auto; padding: 20px;
    }
    #cart-panel.open { right: 0; }
    #cart-panel h5 { font-weight: 700; border-bottom: 2px solid #e94560; padding-bottom: 10px; }
    .cart-item { border-bottom: 1px solid #eee; padding: 10px 0; font-size: .9rem; }
    .cart-total { font-size: 1.1rem; font-weight: 700; color: #e94560; }
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
      <span class="badge bg-info text-dark ms-1">Cliente</span>
    </span>
    <button class="btn btn-outline-light btn-sm position-relative" onclick="toggleCarrito()">
      <i class="bi bi-cart3"></i>
      <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
    </button>
    <a href="logout.php" class="btn btn-outline-light btn-sm">
      <i class="bi bi-box-arrow-right me-1"></i>Salir
    </a>
  </div>
</nav>

<!-- Panel del carrito -->
<div id="cart-panel">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="bi bi-cart3 me-2"></i>Mi Carrito</h5>
    <button class="btn btn-sm btn-outline-secondary" onclick="toggleCarrito()">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  <div id="cart-items">
    <p class="text-muted text-center mt-4">Tu carrito está vacío.</p>
  </div>
  <hr>
  <div class="d-flex justify-content-between cart-total">
    <span>Total:</span>
    <span id="cart-total">$0.00</span>
  </div>
  <button class="btn btn-success w-100 mt-3 fw-bold" onclick="simularCompra()">
    <i class="bi bi-bag-check me-2"></i>Simular Compra
  </button>
</div>

<!-- Contenido principal -->
<div class="container py-4">
  <h5 class="mb-4 text-secondary"><i class="bi bi-grid me-2"></i>Catálogo de Productos</h5>
  <div class="row g-4">
    <?php foreach ($productos as $i => $p): ?>
    <div class="col-sm-6 col-lg-4">
      <div class="card product-card h-100">
        <?php if (file_exists($p['imagen'])): ?>
          <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
        <?php else: ?>
          <div class="img-placeholder"><i class="bi bi-image"></i></div>
        <?php endif; ?>
        <div class="card-body d-flex flex-column">
          <h6 class="card-title fw-bold mb-1"><?= htmlspecialchars($p['nombre']) ?></h6>
          <p class="text-muted small mb-2"><?= htmlspecialchars($p['descripcion']) ?></p>
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="price">$<?= number_format($p['precio'], 2) ?></span>
            <?php if ($p['existencias'] > 10): ?>
              <span class="badge badge-stock-ok small">
                <i class="bi bi-check-circle me-1"></i><?= $p['existencias'] ?> en stock
              </span>
            <?php else: ?>
              <span class="badge badge-stock-low small">
                <i class="bi bi-exclamation-circle me-1"></i>Pocas: <?= $p['existencias'] ?>
              </span>
            <?php endif; ?>
          </div>
          <button class="btn btn-add mt-auto w-100"
                  onclick="agregarAlCarrito(<?= $i ?>, '<?= addslashes($p['nombre']) ?>', <?= $p['precio'] ?>)">
            <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
          </button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <footer class="text-center mt-5">
    &copy; <?= date('Y') ?> Tienda en Línea – Catálogo de Productos
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let carrito = [];

function toggleCarrito() {
  document.getElementById('cart-panel').classList.toggle('open');
}

function agregarAlCarrito(id, nombre, precio) {
  const existente = carrito.find(item => item.id === id);
  if (existente) {
    existente.cantidad++;
  } else {
    carrito.push({ id, nombre, precio, cantidad: 1 });
  }
  renderCarrito();
  // Abrir panel automáticamente
  document.getElementById('cart-panel').classList.add('open');
}

function renderCarrito() {
  const cont    = document.getElementById('cart-items');
  const badge   = document.getElementById('cart-count');
  const totalEl = document.getElementById('cart-total');

  if (carrito.length === 0) {
    cont.innerHTML = '<p class="text-muted text-center mt-4">Tu carrito está vacío.</p>';
    badge.textContent = '0';
    totalEl.textContent = '$0.00';
    return;
  }

  let html  = '';
  let total = 0;
  let cant  = 0;

  carrito.forEach((item, idx) => {
    const subtotal = item.precio * item.cantidad;
    total += subtotal;
    cant  += item.cantidad;
    html  += `
      <div class="cart-item d-flex justify-content-between align-items-start">
        <div>
          <div class="fw-semibold">${item.nombre}</div>
          <div class="text-muted">$${item.precio.toFixed(2)} × ${item.cantidad}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="fw-bold text-danger">$${subtotal.toFixed(2)}</span>
          <button class="btn btn-sm btn-outline-danger px-1 py-0" onclick="quitarItem(${idx})">
            <i class="bi bi-trash3"></i>
          </button>
        </div>
      </div>`;
  });

  cont.innerHTML = html;
  badge.textContent = cant;
  totalEl.textContent = '$' + total.toFixed(2);
}

function quitarItem(idx) {
  carrito.splice(idx, 1);
  renderCarrito();
}

function simularCompra() {
  if (carrito.length === 0) { alert('Agrega al menos un producto.'); return; }
  const nombres = carrito.map(i => `• ${i.nombre} (x${i.cantidad})`).join('\n');
  alert('✅ ¡Compra simulada con éxito!\n\nProductos:\n' + nombres + '\n\nGracias por tu compra.');
  carrito = [];
  renderCarrito();
  toggleCarrito();
}
</script>
</body>
</html>
