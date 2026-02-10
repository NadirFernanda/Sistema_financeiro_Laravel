<div>
    <style>
                    .sidebar .menu a.active {
                        border-radius: 12px;
                        margin-bottom: 18px;
                    }
                    .sidebar .menu a.active:first-child {
                        border-top-left-radius: 12px;
                        border-top-right-radius: 12px;
                        margin-bottom: 6px;
                    }
                    .sidebar .menu a.active:last-child {
                        border-bottom-left-radius: 12px;
                        border-bottom-right-radius: 12px;
                        margin-bottom: 12px;
                    }
                .dashboard-cards {
                    background: #f4f6fa;
                    padding: 12px 0;
                }
                .dashboard-card {
                    background: linear-gradient(135deg,#f4faff 70%,#e3f0ff 100%);
                    border-radius: 24px !important;
                    box-shadow: 0 4px 24px 0 rgba(24,119,242,0.10),0 1.5px 6px 0 rgba(24,119,242,0.08);
                    padding: 40px 36px 32px 36px;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    min-width: 0;
                    min-height: 170px;
                    width: 320px;
                    border: none;
                    transition: box-shadow 0.2s, transform 0.2s;
                }
                .dashboard-card:hover {
                    transform: translateY(-4px) scale(1.03);
                    box-shadow: 0 8px 32px 0 rgba(24,119,242,0.18),0 2px 8px 0 rgba(24,119,242,0.12);
                }
                .dashboard-card .card-title {
                    font-size: 1.28rem;
                    font-weight: 600 !important;
                    font-family: 'Segoe UI', 'Inter', Arial, sans-serif;
                    letter-spacing: 0.01em;
                    margin-bottom: 18px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }
                .dashboard-card .card-value {
                    font-size: 2.5rem;
                    font-weight: 600;
                    font-family: 'Segoe UI', 'Inter', Arial, sans-serif;
                    margin-bottom: 12px;
                }
                .dashboard-card .card-link {
                    color: #1877F2;
                    font-weight: 500;
                    text-decoration: none;
                    margin-top: 8px;
                    font-size: 1.05rem;
                    transition: color 0.2s;
                }
                .dashboard-card .card-link:hover {
                    color: #42a5ff;
                }
                .dashboard-card .icon svg {
                    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.08));
                    stroke-width: 1.6;
                }
            .sidebar .menu a:active,
            .sidebar .menu .logout:active {
                transform: scale(0.96);
                transition: transform 0.1s;
            }
        .sidebar .menu a:active {
            transform: scale(0.96);
            transition: transform 0.1s;
        }
        .sidebar .menu .logout:active {
            transform: scale(0.96);
            transition: transform 0.1s;
        }
    body { background: #f4f6fa; }
    .sidebar {
        background: #102542;
        color: #fff;
        min-height: 100vh;
        padding: 18px 0 0 0;
        width: 340px;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 10;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        font-family: 'Inter', 'Roboto', Arial, sans-serif;
    }
    .sidebar .menu a {
        display: flex;
        align-items: center;
        gap: 2px;
        color: #1877F2;
        background: none !important;
        border-radius: 0;
        padding: 0 2px;
        margin-bottom: 0 !important;
        text-decoration: none;
        font-size: 0.65rem;
        font-weight: 400;
        min-height: 16px;
        line-height: 1.1;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar .menu a.active {
        background: #1877F2 !important;
        color: #fff !important;
        border-radius: 12px;
        margin-bottom: 24px !important;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar .menu a:hover {
        background: #1560c2 !important;
        color: #fff !important;
        border-radius: 16px;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar .menu a:hover .icon svg,
    .sidebar .menu a.active .icon svg {
        stroke: #fff !important;
    }
    .sidebar .menu .icon {
        font-size: 0.8rem;
        color: #1877F2;
        min-width: 16px;
        text-align: left;
    }
    .sidebar .menu .logout {
        color: #e74c3c;
        background: none;
            margin-top: 12px;
        border: none;
        font-weight: bold;
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        justify-content: flex-start;
    }
    }
    .sidebar .logo {
        max-width: 70px;
        margin-bottom: 10px;
    }
    .logo-toto {
        max-width: 60px;
        margin-bottom: 18px;
        display: block;
    }
    .sidebar .title {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    .sidebar .subtitle {
        color: #1877F2;
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    .sidebar .desc {
        color: #b7c7b7;
        font-size: 0.9rem;
        margin-bottom: 24px;
    }
    .sidebar .menu {
        margin-top: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow-y: auto;
    }
    .sidebar .menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        background: #2b4a3b;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 12px;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.2s;
    }
    .sidebar .menu a.active, .sidebar .menu a:hover {
        background: #32805c;
        color: #fff;
    }
    .sidebar .menu .icon {
        font-size: 0.8rem;
        color: #1877F2;
    }
    .sidebar .menu .logout {
        color: #e74c3c;
        background: none;
        margin-top: 24px;
        border: none;
        font-weight: bold;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .main-content {
        margin-left: 270px;
        padding: 40px 32px 32px 32px;
    }
    .dashboard-title {
        color: #1877F2;
        font-size: 2.2rem;
        font-weight: bold;
    }
    .dashboard-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 32px;
    }
    .notification {
        background: #fff6f2;
        border: 2px solid #ff6f3c;
        border-radius: 18px;
        color: #ff6f3c;
        padding: 24px 32px;
        margin-bottom: 32px;
        font-size: 1.15rem;
    }
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
        margin-bottom: 32px;
    }
    .dashboard-card {
        flex: 1;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 28px 24px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        min-width: 0;
        min-height: 170px;
        width: 300px;
    }
    .dashboard-card.faturas { border: 2px solid #ff6f3c; background: #fff6f2; }
    .dashboard-card.despesas { border: 2px solid #42a5ff; background: #f0f6ff; }
    .dashboard-card.relatorios { border: 2px solid #1560c2; background: #f0f6ff; }
    .dashboard-card .card-title {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dashboard-card .card-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .dashboard-card .card-link {
        color: #32805c;
        font-weight: bold;
        text-decoration: none;
        margin-top: 8px;
        font-size: 1rem;
    }
    </style>
    <div class="sidebar">
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:12px 0 0 0;">
            <div style="display:flex;flex-direction:row;align-items:center;justify-content:flex-start;width:100%;gap:16px;margin-top:0;padding-top:0;">
                    <img src="/imagem/logo.png" alt="Logo" style="max-width:70px;display:block;margin-bottom:4px;">
                <div style="flex:1;display:flex;flex-direction:column;align-items:flex-start;">
                    <div style="font-size:1.05rem;font-weight:bold;color:#fff;margin-bottom:0;">Instituto Superior</div>
                    <div style="color:#1877F2;font-size:0.92rem;font-weight:bold;margin-bottom:0;">Politécnico do Bié</div>
                    <div style="color:#b7c7b7;font-size:0.8rem;margin-bottom:0;">Sistema Financeiro</div>
                </div>
            </div>
        </div>
        <div class="menu px-4" style="flex:1;display:flex;flex-direction:column;min-height:0;overflow-y:auto;">
            <a href="/dashboard" class="active"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> </span> Dashboard</a>
            <a href="/movimentos"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="16" height="10" rx="2"/><path d="M6 7V5a4 4 0 0 1 8 0v2"/></svg> </span> Plano de Caixa</a>
            <a href="/faturas"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="14" height="16" rx="2"/><line x1="3" y1="10" x2="17" y2="10"/><line x1="9" y1="16" x2="9" y2="16"/></svg> </span> Gestão de Faturas</a>
            <a href="/usuarios"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a7.5 7.5 0 0 1 13 0"/></svg> </span> Usuários</a>
            <a href="/relatorios"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="19" x2="4" y2="10"/><line x1="9" y1="19" x2="9" y2="4"/><line x1="14" y1="19" x2="14" y2="7"/><line x1="19" y1="19" x2="19" y2="13"/></svg> </span> Relatórios</a>
            <a href="#"><span class="icon"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#1877F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2h-0.12a2 2 0 0 1-2-2v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2v-0.12a2 2 0 0 1 2-2h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h0.09a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2h0.12a2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2v0.12a2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg> </span> Configurações</a>
            <form method="POST" action="/logout" style="margin-top:0;">
                @csrf
                <button type="submit" class="logout" style="margin-top:32px; display:flex; align-items:center; gap:8px; color:#fff; font-weight:bold; font-size:1.1rem; background:#1877F2; border:none; cursor:pointer; border-radius:12px; padding:12px 24px; transition:background 0.2s;">
                    <span class="icon" style="display:flex; align-items:center; min-width:16px; text-align:left;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </span>
                    <span style="margin-left:0;">Sair do Sistema</span>
                </button>
            </form>
        </div>
    </div>
    <div class="dashboard-topbar" style="position:fixed;top:0;left:340px;right:0;height:128px;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.04);z-index:20;display:flex;flex-direction:column;justify-content:center;padding:36px 48px 0 48px;">
        <div class="dashboard-title" style="color:#1877F2;font-size:2.5rem;font-weight:bold;margin-bottom:0.2rem;">Módulo financeiro</div>
        <div class="dashboard-subtitle" style="color:#6c757d;font-size:1.2rem;">Sistema de despesas e controle de faturas.</div>
    </div>
    <div class="main-content" style="margin-top:92px;">
                <div class="dashboard-notification" style="background:#f4faff;border:2px solid #1877F2;border-radius:24px;padding:32px 40px;margin-bottom:32px;display:flex;align-items:flex-start;gap:18px;">
                    <span class="icon" style="display:flex;align-items:center;justify-content:center;min-width:38px;">
                        <i data-feather="info" style="width:38px;height:38px;stroke:#1877F2;"></i>
                    </span>
                    <div>
                        <div style="color:#1877F2;font-size:1.5rem;font-weight:bold;margin-bottom:0.2rem;">Nenhuma notificação encontrada</div>
                        <div style="color:#6c757d;font-size:1.15rem;">Verifique novamente mais tarde.</div>
                    </div>
                </div>
        <div class="dashboard-cards" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:24px;">
            <div class="dashboard-card faturas" style="background:#f4faff;border:1.5px solid #1877F2;border-radius:16px;">
                <div class="card-title" style="color:#1877F2;font-weight:bold;font-size:1.25rem;display:flex;align-items:center;gap:10px;">
                    <span class="icon" style="display:flex;align-items:center;">
                        <i data-feather="file-text" style="width:28px;height:28px;stroke:#42a5ff;"></i>
                    </span>
                    Faturas
                </div>
                <div class="card-value" style="color:#1877F2;font-size:2.3rem;font-weight:bold;">{{ $totalFaturas }}</div>
                <a href="{{ route('faturas') }}" class="card-link" style="color:#222;font-weight:500;font-size:1.05rem;text-decoration:none;">Mais informações &rarr;</a>
            </div>
            <div class="dashboard-card despesas" style="background:#f4faff;border:1.5px solid #1877F2;border-radius:16px;">
                <div class="card-title" style="color:#1877F2;font-weight:bold;font-size:1.25rem;display:flex;align-items:center;gap:10px;">
                    <span class="icon" style="display:flex;align-items:center;">
                        <i data-feather="dollar-sign" style="width:28px;height:28px;stroke:#1877F2;"></i>
                    </span>
                    Despesas
                </div>
                <div class="card-value" style="color:#1877F2;font-size:2.3rem;font-weight:bold;">{{ $totalDespesas }}</div>
                <a href="{{ route('movimentos') }}" class="card-link" style="color:#222;font-weight:500;font-size:1.05rem;text-decoration:none;">Mais informações &rarr;</a>
            </div>
            <div class="dashboard-card relatorios" style="background:#f4faff;border:1.5px solid #1877F2;border-radius:16px;">
                <div class="card-title" style="color:#1877F2;font-weight:bold;font-size:1.25rem;display:flex;align-items:center;gap:10px;">
                    <span class="icon" style="display:flex;align-items:center;">
                        <i data-feather="bar-chart-2" style="width:28px;height:28px;stroke:#1877F2;"></i>
                    </span>
                    Relatórios
                </div>
                <div class="card-value" style="color:#1877F2;font-size:2.3rem;font-weight:bold;">{{ $totalRelatorios }}</div>
                <a href="{{ route('relatorios') }}" class="card-link" style="color:#222;font-weight:500;font-size:1.05rem;text-decoration:none;">Mais informações &rarr;</a>
            </div>
        </div>
        <div class="dashboard-cards" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            <div class="dashboard-card" style="background:#fff;border:1.2px solid #e6e9ef;border-radius:16px;">
                <div class="card-title" style="color:#1877F2;font-weight:bold;font-size:1.18rem;display:flex;align-items:center;gap:10px;">
                    <span class="icon" style="display:flex;align-items:center;">
                        <i data-feather="user" style="width:22px;height:22px;stroke:#1877F2;"></i>
                    </span>
                    Minha Conta
                </div>
                <div style="margin-top:8px;margin-bottom:8px;color:#333;font-size:1.05rem;font-weight:600;">{{ optional(Auth::user())->nome ?? '—' }}</div>
                <div style="margin-bottom:12px;">
                    @php
                        $role = optional(Auth::user())->role ?? 'Usuário';
                        $badgeColor = match(strtolower($role)) {
                            'admin' => '#1560c2',
                            'financeiro' => '#2e7d32',
                            'presidente' => '#8e24aa',
                            'gabinete do presidente' => '#8e24aa',
                            'executor' => '#ff6f3c',
                            default => '#6c757d',
                        };
                    @endphp
                    <span style="display:inline-block;padding:6px 10px;border-radius:999px;background:{{ $badgeColor }};color:#fff;font-weight:700;font-size:0.9rem;">{{ ucfirst($role) }}</span>
                </div>
                <div style="margin-top:auto;display:flex;gap:12px;align-items:center;">
                    <a href="/usuarios" class="card-link" style="color:#32805c;font-weight:600;text-decoration:none;">Perfil</a>
                    <a href="/password/reset" class="card-link" style="color:#32805c;font-weight:600;text-decoration:none;">Alterar senha</a>
                </div>
            </div>
        </div>
    </div>
</div>
