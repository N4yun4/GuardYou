@extends('layouts.app')

@section('title', 'Security Command Center')

@push('styles')
<style>
    .dashboard-vault {
        min-height: 100vh;
        background: var(--color-surface);
        padding: 8rem 3rem 4rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .dashboard-header {
        margin-bottom: 5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .dashboard-title {
        font-size: 3.5rem;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: -0.04em;
        line-height: 1;
    }
    .dashboard-title span { color: var(--color-gold); }

    /* ===== CTA PANEL ===== */
    .deployment-cta {
        background: linear-gradient(135deg, rgba(220,20,60,0.05) 0%, transparent 100%);
        border: 1px solid rgba(220,20,60,0.1);
        border-radius: 12px;
        padding: 4rem;
        text-align: center;
        margin-bottom: 5rem;
        position: relative;
        overflow: hidden;
    }
    .deployment-cta::before {
        content: 'TACTICAL';
        position: absolute; top: -1rem; right: -1rem;
        font-size: 8rem; font-weight: 900; color: rgba(255,255,255,0.02);
        letter-spacing: -0.05em; pointer-events: none;
    }

    /* ===== MISSION GRID ===== */
    .section-label {
        font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: 0.25em; color: var(--color-gold);
        margin-bottom: 2rem; display: block;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2.5rem;
        margin-bottom: 6rem;
    }

    .mission-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 2.5rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
    }
    .mission-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(220,20,60,0.25);
        transform: translateY(-5px);
    }

    .card-status {
        position: absolute; top: 2.5rem; right: 2.5rem;
        font-size: 0.6rem; font-weight: 900; text-transform: uppercase;
        letter-spacing: 0.15em; color: var(--color-gold);
        padding: 0.3rem 0.6rem; background: rgba(220,20,60,0.1);
        border-radius: 2px;
    }

    .card-agent { font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: -0.02em; margin-bottom: 0.5rem; display: block; }
    .card-meta { font-size: 0.75rem; color: var(--color-on-surface-variant); font-weight: 600; margin-bottom: 2rem; display: block; }

    .card-actions { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05); }
    .card-link { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-gold); text-decoration: none; }
    .card-link:hover { opacity: 0.7; }

</style>
@endpush

@section('content')
<div class="dashboard-vault">

    <header class="dashboard-header">
        <div>
            <span class="hero-label" style="margin-bottom:1rem;">Command Interface</span>
            <h1 class="dashboard-title">Security <span>Command</span></h1>
        </div>
        <div style="text-align:right;">
            <span class="strip-lbl">Auth Token</span>
            <span class="strip-val" style="display:block; font-size:1.2rem; opacity:0.5;">{{ strtoupper(substr(auth()->user()->name, 0, 3)) }}-{{ date('Ymd') }}</span>
        </div>
    </header>

    <!-- DEPLOYMENT CTA -->
    <section class="deployment-cta">
        <h2 class="dashboard-title" style="font-size:2.5rem; margin-bottom:1rem;">Protective Asset Required?</h2>
        <p style="color:var(--color-on-surface-variant); max-width:500px; margin:0 auto 2.5rem;">Access the world's most elite personal protection network. Secure your life and legacy with a single mandate.</p>
        <a href="{{ route('bodyguards.index') }}" class="btn-primary">Initiate Deployment Protocol</a>
    </section>

    <!-- ACTIVE ASSIGNMENTS -->
    <section class="mission-section">
        <span class="section-label">Active Protection Mandates</span>
        @if($activeBookings->isEmpty())
            <div style="padding:5rem; text-align:center; background:rgba(255,255,255,0.01); border-radius:8px; border:1px dashed rgba(255,255,255,0.05);">
                <p style="color:var(--color-on-surface-variant); font-size:0.9rem;">No active tactical assignments detected in the vault.</p>
            </div>
        @else
            <div class="mission-grid">
                @foreach($activeBookings as $booking)
                <div class="mission-card">
                    <span class="card-status">{{ strtoupper($booking->status) }}</span>
                    <span class="entry-label" style="margin-bottom:0.5rem; display:block;">Elite Sentinel</span>
                    <span class="card-agent">{{ $booking->bodyguard->user->name }}</span>
                    <span class="card-meta">
                        {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} — 
                        {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                    </span>
                    
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem; margin-top:1.5rem;">
                        <div class="data-item" style="padding-left:1rem; border-left:1px solid rgba(220,20,60,0.2);">
                            <span class="entry-label" style="font-size:0.55rem;">Daily Rate</span>
                            <span style="font-size:0.9rem; font-weight:800;">IDR {{ number_format($booking->bodyguard->daily_rate, 0, ',', '.') }}</span>
                        </div>
                        <div class="data-item" style="padding-left:1rem; border-left:1px solid rgba(220,20,60,0.2);">
                            <span class="entry-label" style="font-size:0.55rem;">Mission Status</span>
                            <span style="font-size:0.9rem; font-weight:800; color:#4ade80;">Operational</span>
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('bookings.show', $booking) }}" class="card-link">View Mandate</a>
                        <a href="{{ route('chat.show', $booking) }}" class="card-link" style="color:var(--color-on-surface); margin-left:auto;">🛰 Uplink</a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- PENDING AUTHORIZATIONS -->
    @if(!$pendingBookings->isEmpty())
    <section class="mission-section">
        <span class="section-label">Pending Tactical Authorizations</span>
        <div class="mission-grid">
            @foreach($pendingBookings as $booking)
            <div class="mission-card" style="border-style: dashed;">
                <span class="card-status" style="background:rgba(255,255,255,0.05); color:var(--color-on-surface-variant);">AWAITING COLLATERAL</span>
                <span class="entry-label" style="margin-bottom:0.5rem; display:block;">Target Sentinel</span>
                <span class="card-agent">{{ $booking->bodyguard->user->name }}</span>
                <span class="card-meta">Mission ID: #GY-{{ $booking->id }}</span>
                
                <div style="margin-top:1.5rem;">
                    <span class="entry-label" style="font-size:0.55rem;">Collateral Required</span>
                    <span style="font-size:1.2rem; font-weight:900; color:var(--color-gold); display:block;">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>

                <div class="card-actions">
                    <a href="{{ route('bookings.show', $booking) }}" class="btn-primary" style="width:100%; text-align:center; padding:0.8rem; font-size:0.75rem;">Authorize Deployment</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection
