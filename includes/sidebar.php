<?php
$currentUrl = $_SERVER['REQUEST_URI'];
echo $currentUrl;
?>

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky" style="background: gainsboro;">
        <ul class="nav flex-column">
            <li
                class="nav-item btn-outline-light <?php echo ($currentUrl === '/' || $currentUrl === '/index.php' || strpos($currentUrl, 'conponents/prayertime') !== false) ? ' active' : ''; ?>">
                <a class="nav-link" href="/index.php">
                    <span data-feather="clock"></span>
                    Prayer Times Table
                </a>
            </li>
            <li
                class="nav-item btn-outline-light <?php echo strpos($currentUrl, 'conponents/subscribers') !== false ? ' active' : ''; ?>">
                <a class="nav-link" href="/conponents/subscribers/index.php">
                    <span data-feather="users"></span>
                    Subscribers
                </a>
            </li>
            <li
                class="nav-item btn-outline-light  <?php echo strpos($currentUrl, 'conponents/box') !== false ? ' active' : ''; ?>">
                <a class="nav-link" href="/conponents/box/index.php">
                    <span data-feather="box"></span>
                    Boxs
                </a>
            </li>
            <li
                class="nav-item btn-outline-light  <?php echo strpos($currentUrl, 'conponents/song') !== false ? ' active' : ''; ?>">
                <a class="nav-link" href="/conponents/song/index.php">
                    <span data-feather="music"></span>
                    Songs
                </a>
            </li>
        </ul>
    </div>
</nav>