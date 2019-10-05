<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link {{ ($active == 'home') ?? 'active' }}" href="{{ route('company') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($active == 'ranks') ?? 'active' }}" href="{{ route('company.ranks') }}">Ranks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($active == 'employees') ?? 'active' }}" href="{{ route('company.employees') }}">Employees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($active == 'management') ?? 'active' }}" href="#">Management</a>
        </li>
    </ul>
</div>
