<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      {{-- Home --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="bi bi-grid"></i>
          <span>Home</span>
        </a>
      </li>


    @if (Auth::user()->role == 'admin')

    {{-- ALL User --}}
    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-grid"></i>
        <span>User</span>
      </a>
    </li>
      {{-- Category - News --}}
      <li class="nav-item">
        <a class="nav-link mt-3" href="{{ route('category.index') }}">
          <i class="bi bi-basket2"></i>
          <span>Category</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link mt-3" href="{{ route('news.index') }}">
          <i class="ri-archive-fill"></i>
          <span>News</span>
        </a>
      </li>
    @else
      
    @endif

    </ul>

  </aside>