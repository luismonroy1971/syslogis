<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Inventario de Prótesis</title>
    <link rel="stylesheet" href="<?php echo $this->asset('css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('css/auth.css'); ?>"
    <link rel="stylesheet" href="<?php echo $this->asset('css/components/header.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('css/components/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('css/components/table.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('css/components/form.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('css/components/alert.css'); ?>">
</head>
<body>
    <div class="app-container">
        <?php if (isset($_SESSION['user_id'])): ?>
        <header class="app-header">
            <div class="header-brand">
                <h1>SysLogis</h1>
            </div>
            <nav class="header-nav">
                <ul>
                    <li><a href="<?php echo $this->url('prothesis'); ?>">Inventario</a></li>
                    <li><a href="<?php echo $this->url('prothesis/create'); ?>">Nueva Prótesis</a></li>
                    <li><a href="<?php echo $this->url('prothesis/report'); ?>">Reportes</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Buscar por código...">
                    <button type="button" id="searchButton">
                        <svg viewBox="0 0 24 24" width="24" height="24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </header>
        <?php endif; ?>

        <div class="app-content">
            <?php if (isset($_SESSION['user_id'])): ?>
            <aside class="app-sidebar">
                <nav class="sidebar-nav">
                    <ul>
                        <li>
                            <a href="<?php echo $this->url('dashboard'); ?>" class="nav-item">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->url('prothesis'); ?>" class="nav-item">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                                    <path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7z"/>
                                </svg>
                                <span>Inventario</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->url('prothesis/report'); ?>" class="nav-item">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                                    <path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/>
                                </svg>
                                <span>Reportes</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->url('settings'); ?>" class="nav-item">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/>
                                </svg>
                                <span>Configuración</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
            <?php endif; ?>

            <main class="main-content">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error">
                        <?php echo $this->escape($error); ?>
                    </div>
                <?php endif; ?>

                <?php echo $content; ?>
            </main>
        </div>
    </div>

    <script src="<?php echo $this->asset('js/utils/api.js'); ?>"></script>
    <script src="<?php echo $this->asset('js/utils/validation.js'); ?>"></script>
    <script src="<?php echo $this->asset('js/components/search.js'); ?>"></script>
    <script src="<?php echo $this->asset('js/components/alert.js'); ?>"></script>
    <script src="<?php echo $this->asset('js/main.js'); ?>"></script>
</body>
</html>