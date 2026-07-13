  <header>
      @php
          $headerMenu = App\Models\Menu::where('position', 'header')
              ->with([
                  'menus' => function ($q) {
                      $q->where('enabled', true)->with([
                          'children' => function ($q2) {
                              $q2->where('enabled', true)->with([
                                  'children' => function ($q3) {
                                      $q3->where('enabled', true);
                                  },
                              ]);
                          },
                      ]);
                  },
              ])
              ->first();
          $menuItems = $headerMenu->menus->where('enabled', true);

      @endphp
      <nav class="navbar navbar-expand-xl bg-common  z-3 w-100 d-flex flex-column pb-2">
          {{-- Logo  --}}
          <div class="container d-flex w-100 justify-content-between align-items-center mb-3">
              <!-- Left: Logo -->
              <a class="navbar-brand d-inline" href="{{ route('home') }}">
                  <img src="{{ getImageUrl($settings['store_logo']) }}" alt="Bangladesh Flag & NPC Logo" class="img-fluid"
                      style="max-height:50px;">
              </a>

              <!-- Center: Search bar with filter -->
              <form action="#" method="GET" class="d-flex mx-xl-3 flex-grow-1 justify-content-xl-center">
                  <div class="input-group my-2 my-xl-0 mb-xl-0" style="max-width:400px;">
                      <select aria-label="Filter content type" class="form-select rounded-0" name="filter"
                          style="max-width:95px;">
                          <option value="news">News</option>
                          <option value="players">Athletes</option>
                          <option value="posts">Posts</option>
                          <option value="events">Events</option>
                      </select>
                      <input type="text" class="form-control border-none" name="q" placeholder="Search..."
                          aria-label="Search">
                      <button aria-label="Search" class="btn btn-dark rounded-0" type="submit">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                              class="bi bi-search" viewBox="0 0 16 16">
                              <path
                                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                          </svg>
                      </button>
                  </div>
              </form>

              <!-- Right: Login/Register -->
              <div class="d-flex">
                  @guest
                      <a href="#" class="btn btn-success me-2 rounded-0">Sponsor</a>
                      <a href="#" class="btn btn-success me-2 rounded-0">Login/Register</a>
                  @else
                      <a href="#" class="btn btn-success me-2 rounded-0">Dashboard</a>
                      <form action="#" method="POST">
                          @csrf
                          <button aria-label="Logout" type="submit" class="btn btn-danger rounded-0">Logout</button>
                      </form>
                  @endguest
              </div>
          </div>

          {{-- Logo  --}}
          <div class="container">


              {{-- Mobile Menu Button --}}
              <button aria-label="Toggle navigation" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarNav">
                  <span class="navbar-toggler-icon"></span>
              </button>

              {{-- Navigation Menu --}}
              <div class="collapse navbar-collapse justify-content-start custom-nav-manu" id="navbarNav">
                  <ul class="navbar-nav gap-md-4 gap-8px gap-3 mt-3 mt-lg-0 text-md-center text-lg-start flex-wrap">

                      @foreach ($menuItems as $item)
                          @if ($item->children->count() > 0)
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" id="menu-{{ $item->id }}"
                                      role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span>{{ $item->name }}</span>
                                      <svg width="13" height="8" viewBox="0 0 13 8" fill="none"
                                          xmlns="http://www.w3.org/2000/svg">
                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.65703 7.071L2.66411e-05 1.414L1.41403 -4.94551e-07L6.36403 4.95L11.314 -6.18079e-08L12.728 1.414L7.07103 7.071C6.8835 7.25847 6.62919 7.36379 6.36403 7.36379C6.09886 7.36379 5.84455 7.25847 5.65703 7.071Z"
                                              fill="white" />
                                      </svg>
                                  </a>
                                  <ul class="dropdown-menu" aria-labelledby="menu-{{ $item->id }}">
                                      @foreach ($item->children as $child)
                                          @if ($child->children->count() > 0)
                                              <li class="dropdown-submenu">
                                                  <a class="dropdown-item dropdown-toggle" href="#">
                                                      <span>
                                                          {{ $child->name }}
                                                      </span>
                                                      <svg width="13px" height="8px" viewBox="0 0 512 512"
                                                          xmlns="http://www.w3.org/2000/svg">
                                                          <polygon
                                                              points="150.46 478 129.86 456.5 339.11 256 129.86 55.49 150.46 34 382.14 256 150.46 478"
                                                              fill="currentColor" stroke="currentColor"
                                                              stroke-width="45" stroke-linejoin="round" />
                                                      </svg>


                                                  </a>

                                                  <ul class="dropdown-menu">
                                                      @foreach ($child->children as $grandchild)
                                                          <li><a class="dropdown-item"
                                                                  href="{{ $grandchild->url }}">{{ $grandchild->name }}</a>
                                                          </li>
                                                      @endforeach
                                                  </ul>
                                              </li>
                                          @else
                                              <li><a class="dropdown-item"
                                                      href="{{ $child->url }}">{{ $child->name }}</a></li>
                                          @endif
                                      @endforeach
                                  </ul>
                              </li>
                          @else
                              <li class="nav-item">
                                  <a class="nav-link p-0"
                                      href="{{ $item->url }}"><span>{{ $item->name }}</span></a>
                              </li>
                          @endif
                      @endforeach
                  </ul>
              </div>
          </div>
      </nav>
  </header>
