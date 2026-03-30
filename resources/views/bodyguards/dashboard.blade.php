@extends('layouts.app')

@section('title', 'Agent Deployment Hub')

@push('styles')
<style>
    .agent-vault {
        min-height: 100vh;
        background: var(--color-surface);
        padding: 8rem 3rem 4rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .agent-header {
        margin-bottom: 5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .agent-title {
        font-size: 3.5rem;
        font-weight: 950;
        text-transform: uppercase;
        letter-spacing: -0.04em;
        line-height: 1;
    }
    .agent-title span { color: var(--color-gold); }

    /* ===== VERIFICATION ALERT ===== */
    .verification-status {
        background: rgba(239, 68, 68, 0.05);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 8px; padding: 2.5rem;
        margin-bottom: 5rem; text-align: center;
    }
    .status-alert { font-size: 0.7rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; color: #f87171; margin-bottom: 0.5rem; display: block; }
    .status-msg { font-size: 1.2rem; font-weight: 800; color: var(--color-on-surface); }

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

    .card-client { font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: -0.02em; margin-bottom: 0.5rem; display: block; }
    .card-meta { font-size: 0.75rem; color: var(--color-on-surface-variant); font-weight: 600; margin-bottom: 2rem; display: block; }

    .card-actions { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05); }
    .card-link { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-gold); text-decoration: none; }
    .card-link:hover { opacity: 0.7; }

    /* ===== REVENUE TABLE ===== */
    .revenue-vault {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px; overflow: hidden;
    }
    .revenue-table { width: 100%; border-collapse: collapse; }
    .revenue-table th { background: rgba(255, 255, 255, 0.03); padding: 1.5rem 2.5rem; text-align: left; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--color-on-surface-variant); }
    .revenue-table td { padding: 1.5rem 2.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); }
    .revenue-val { font-size: 1rem; font-weight: 950; color: var(--color-gold); letter-spacing: -0.02em; }

</style>
@endpush

@section('content')
<div class="agent-vault">

    @if(!$bodyguard->is_verified)
    <div class="verification-status">
        <span class="status-alert">SECURITY CLEARANCE PENDING</span>
        <h2 class="status-msg">Identity Verification Protocol in Progress by Command.</h2>
        <p style="color:var(--color-on-surface-variant); margin-top:1rem; font-size:0.85rem;">Mandates are restricted until verification token is authorized.</p>
    </div>
    @endif

    <header class="agent-header">
        <div>
            <span class="hero-label" style="margin-bottom:1rem;">Field Operative Interface</span>
            <h1 class="agent-title">Agent <span>Deployment</span> Hub</h1>
        </div>
        <div style="text-align:right; display:flex; flex-direction:column; align-items:flex-end; gap:1rem;">
            <a href="{{ route('bodyguard.profile.edit') }}" class="btn-primary" style="font-size:0.72rem; padding:0.6rem 1.25rem;">
                Edit Profil
            </a>
            <div>
                <span class="strip-lbl">Operative ID</span>
                <span class="strip-val" style="display:block; font-size:1.2rem; opacity:0.5;">SENTINEL-{{ $bodyguard->id }}</span>
            </div>
        </div>
    </header>

    <!-- ACTIVE MISSIONS -->
    <section class="mission-section">
        <span class="section-label">Active Field Assignments</span>
        @if($activeMissions->isEmpty())
            <div style="padding:5rem; text-align:center; background:rgba(255,255,255,0.01); border-radius:8px; border:1px dashed rgba(255,255,255,0.05);">
                <p style="color:var(--color-on-surface-variant); font-size:0.9rem;">No active protection details authorized.</p>
            </div>
        @else
            <div class="mission-grid">
                @foreach($activeMissions as $mission)
                <div class="mission-card">
                    <span class="card-status">{{ strtoupper($mission->status) }}</span>
                    <span class="entry-label" style="margin-bottom:0.5rem; display:block;">Target Client</span>
                    <span class="card-client">{{ $mission->user->name }}</span>
                    <span class="card-meta">Mission ID: #GY-{{ $mission->id }} // {{ \Carbon\Carbon::parse($mission->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($mission->end_date)->format('M d, Y') }}</span>
                    
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem; margin-top:1.5rem;">
                        <div class="data-item" style="padding-left:1rem; border-left:1px solid rgba(220,20,60,0.2);">
                            <span class="entry-label" style="font-size:0.55rem;">Authorized Rev.</span>
                            <span style="font-size:0.9rem; font-weight:800; color:var(--color-gold);">IDR {{ number_format($mission->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="data-item" style="padding-left:1rem; border-left:1px solid rgba(220,20,60,0.2);">
                            <span class="entry-label" style="font-size:0.55rem;">Link Status</span>
                            <span style="font-size:0.9rem; font-weight:800; color:#4ade80;">OPERATIONAL</span>
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('bookings.show', $mission) }}" class="card-link">Mission Parameters</a>
                        <a href="{{ route('chat.show', $mission) }}" class="card-link" style="color:#60a5fa; margin-left:auto;">📡 Secure Link</a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- UPCOMING / PENDING -->
    @if(!$upcomingMissions->isEmpty())
    <section class="mission-section">
        <span class="section-label">Upcoming Tactical Mandates</span>
        <div class="mission-grid">
            @foreach($upcomingMissions as $mission)
            <div class="mission-card" style="border-style: dashed;">
                <span class="card-status" style="background:rgba(255,255,255,0.05); color:var(--color-on-surface-variant);">REQUESTED</span>
                <span class="entry-label" style="margin-bottom:0.5rem; display:block;">Prospect Client</span>
                <span class="card-client">{{ $mission->user->name }}</span>
                <span class="card-meta">Commencement: {{ \Carbon\Carbon::parse($mission->start_date)->format('M d, Y') }}</span>
                
                <div class="card-actions">
                    <a href="{{ route('bookings.show', $mission) }}" class="btn-primary" style="width:100%; text-align:center; padding:0.8rem; font-size:0.75rem;">Acknowledge Mandate</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- HISTORY LOG -->
    <section class="mission-section" style="margin-top:6rem;">
        <span class="section-label" style="margin-bottom:1.5rem;">Mission Vault History</span>
        <div class="revenue-vault">
            @if($completedMissions->isEmpty())
                <p style="padding:4rem; text-align:center; color:var(--color-on-surface-variant); font-size:0.9rem;">Operative has no recorded historical archives.</p>
            @else
                <table class="revenue-table">
                    <thead>
                        <tr>
                            <th>Mission Client</th>
                            <th>Extraction Date</th>
                            <th>Net Revenue Authorized</th>
                            <th>Integrity Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedMissions as $mission)
                        <tr>
                            <td><span style="font-weight:800; text-transform:uppercase;">{{ $mission->user->name }}</span><br><span style="font-size:0.65rem; opacity:0.5;">#GY-{{ $mission->id }}</span></td>
                            <td><span style="font-size:0.85rem; font-weight:600;">{{ $mission->end_date->format('M d, Y') }}</span></td>
                            <td><span class="revenue-val">IDR {{ number_format($mission->total_price, 0, ',', '.') }}</span></td>
                            <td><span class="card-status" style="position:static; padding:0.2rem 0.5rem;">COMPLETED</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>

</div>
@endsection
