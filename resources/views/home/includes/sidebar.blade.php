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
      <a class="nav-link" href="{{ route('allUser') }}">
        <i class="bi bi-person-circle"></i>
        <span>User</span>
      </a>
    </li>
      {{-- Category - News --}}
      <li class="nav-item">
        <a class="nav-link mt-3" href="{{ route('category.index') }}">
          <i class="bi bi-chat-text-fill"></i>
          <span>Category</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link mt-3" href="{{ route('news.index') }}">
          <i class="ri-book-2-line"></i>
          <span>News</span>
        </a>
      </li>
    @else
      
    @endif

    </ul>

  </aside>