@extends('layouts.app')

@section('title', 'Global Command & Control')

@push('styles')
<style>
    .admin-vault {
        min-height: 100vh;
        background: var(--color-surface);
        padding: 8rem 3rem 4rem;
        max-width: 1300px;
        margin: 0 auto;
    }

    .admin-header {
        margin-bottom: 5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .admin-title {
        font-size: 3.5rem;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: -0.04em;
        line-height: 1;
    }
    .admin-title span { color: var(--color-gold); }

    /* ===== STATS GRID ===== */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 5rem;
    }

    .metric-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .metric-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 2px;
        background: linear-gradient(90deg, transparent, rgba(233, 193, 118, 0.2), transparent);
    }

    .metric-label {
        font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: 0.25em; color: var(--color-on-surface-variant);
        margin-bottom: 1rem; display: block;
    }
    .metric-value {
        font-size: 2.5rem; font-weight: 950; letter-spacing: -0.04em;
        color: var(--color-on-surface); line-height: 1;
    }
    .metric-value.gold { color: var(--color-gold); }

    /* ===== ACTION TILES ===== */
    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        margin-bottom: 6rem;
    }

    .action-tile {
        background: linear-gradient(135deg, rgba(255,255,255,0.02), transparent);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 3.5rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .action-tile:hover {
        border-color: rgba(233, 193, 118, 0.2);
        background: rgba(255,255,255,0.03);
        transform: translateY(-5px);
    }

    .tile-title { font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: -0.02em; margin-bottom: 1rem; display: block; }
    .tile-desc { font-size: 0.9rem; color: var(--color-on-surface-variant); line-height: 1.6; margin-bottom: 2.5rem; }

    /* ===== ACTIVITY FEED ===== */
    .feed-vault {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px; overflow: hidden;
    }
    .feed-table { width: 100%; border-collapse: collapse; }
    .feed-table th { background: rgba(255, 255, 255, 0.03); padding: 1.5rem 2.5rem; text-align: left; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--color-on-surface-variant); }
    .feed-table td { padding: 1.5rem 2.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); }

    .status-pill {
        padding: 0.4rem 0.8rem; border-radius: 4px;
        font-size: 0.6rem; font-weight: 900; text-transform: uppercase;
        letter-spacing: 0.15em; border: 1px solid rgba(255,255,255,0.1);
    }

</style>
@endpush

@section('content')
<div class="admin-vault">

    <header class="admin-header">
        <div>
            <span class="hero-label" style="margin-bottom:1rem;">Platform Sovereignty</span>
            <h1 class="admin-title">Command <span>Control</span></h1>
        </div>
        <div style="text-align:right;">
            <span class="strip-lbl">Root Authority</span>
            <span class="strip-val" style="display:block; font-size:1.2rem; opacity:0.5;">VAULT-ADM-{{ date('His') }}</span>
        </div>
    </header>

    <!-- GLOBAL METRICS -->
    <section class="metrics-grid">
        <div class="metric-card">
            <span class="metric-label">Total Operational Assets</span>
            <div class="metric-value">{{ number_format($stats['total_users']) }}</div>
        </div>
        <div class="metric-card">
            <span class="metric-label">Verified Field Agents</span>
            <div class="metric-value">{{ number_format($stats['total_bodyguards']) }}</div>
        </div>
        <div class="metric-card">
            <span class="metric-label">Pending Authorizations</span>
            <div class="metric-value {{ $stats['pending_verifs'] > 0 ? 'gold' : '' }}">
                {{ number_format($stats['pending_verifs']) }}
            </div>
        </div>
        <div class="metric-card">
            <span class="metric-label">Authorized Revenue</span>
            <div class="metric-value gold">IDR {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
        </div>
    </section>

    <!-- TACTICAL TILES -->
    <section class="action-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
        <div class="action-tile">
            <span class="hero-label" style="color:var(--color-gold); margin-bottom:0.5rem;">Agent Registry</span>
            <span class="tile-title">Operational Verification</span>
            <p class="tile-desc">Review and authorize new bodyguard applications. Ensure field agents meet the required security standards before activation.</p>
            <a href="{{ route('admin.bodyguards.index') }}" class="btn-primary" style="padding:1rem 2rem; display:inline-block;">Manage Agents</a>
        </div>
        <div class="action-tile">
            <span class="hero-label" style="color:var(--color-gold); margin-bottom:0.5rem;">User Database</span>
            <span class="tile-title">Account Management</span>
            <p class="tile-desc">View, edit, and manage all registered user accounts on the platform. Control roles and access levels.</p>
            <a href="{{ route('admin.users.index') }}" class="btn-primary" style="padding:1rem 2rem; display:inline-block;">Manage Users</a>
        </div>
        <div class="action-tile">
            <span class="hero-label" style="color:var(--color-gold); margin-bottom:0.5rem;">Mission Ledger</span>
            <span class="tile-title">Deployment Oversight</span>
            <p class="tile-desc">Monitor every active protection mandate across the globe. Maintain real-time oversight of critical mission statuses.</p>
            <a href="{{ route('admin.bookings.index') }}" class="btn-primary" style="padding:1rem 2rem; display:inline-block;">View Mission Log</a>
        </div>
    </section>

    <!-- ACTIVITY FEED -->
    <section class="feed-section">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem;">
            <span class="section-label" style="margin:0;">Recent Tactical Activity</span>
            <a href="{{ route('admin.bookings.index') }}" style="font-size:0.7rem; font-weight:800; text-transform:uppercase; color:var(--color-gold); text-decoration:none;">Comprehensive Log →</a>
        </div>
        <div class="feed-vault">
            <table class="feed-table">
                <thead>
                    <tr>
                        <th>Mission Order</th>
                        <th>Operative Detail</th>
                        <th>Mandate Amount</th>
                        <th>Log Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_bookings as $booking)
                    <tr>
                        <td>
                            <span style="font-weight:900; letter-spacing:0.05em; color:var(--color-on-surface);">#GY-{{ $booking->id }}</span><br>
                            <span style="font-size:0.65rem; opacity:0.5; font-weight:800; text-transform:uppercase;">{{ $booking->created_at->format('d M Y // H:i') }}</span>
                        </td>
                        <td>
                            <span style="font-size:0.85rem; font-weight:800; color:var(--color-on-surface);">{{ $booking->user->name }}</span>
                            <span style="font-size:0.7rem; margin:0 0.5rem; opacity:0.3;">←</span>
                            <span style="font-size:0.85rem; font-weight:800; color:var(--color-gold);">{{ $booking->bodyguard->user->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span style="font-size:1.1rem; font-weight:950; letter-spacing:-0.02em;">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="status-pill" style="
                                @if($booking->status === 'paid' || $booking->status === 'active') border-color: #4ade80; color: #4ade80; background:rgba(74,222,128,0.1); 
                                @elseif($booking->status === 'pending') border-color: var(--color-gold); color: var(--color-gold); background:rgba(220,20,60,0.1);
                                @endif
                            ">{{ strtoupper($booking->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:5rem; color:var(--color-on-surface-variant); font-size:0.9rem;">No mandates currently recorded in the mission archives.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
