<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
  
      <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#sidebarMenu" 
        aria-controls="sidebarMenu" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="sidebarMenu">
        <div class="bg-dark text-white" style="width: 250px; height: 100vh;">
          <div class="p-3">
            <hr class="border-secondary">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a 
                  class="nav-link text-white {{ Route::is('dashboard') ? 'active bg-secondary' : '' }} rounded mb-2" 
                  href="{{ route('dashboard') }}"
                >
                  <i class="bi bi-house me-2"></i>Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a 
                  class="nav-link text-white {{ Route::is('categories') ? 'active bg-secondary' : '' }} rounded mb-2" 
                  href="{{ route('categories') }}"
                >
                  <i class="bi bi-bag me-2"></i>Categories
                </a>
              </li>
              <li class="nav-item">
                <a 
                  class="nav-link text-white {{ Route::is('product') ? 'active bg-secondary' : '' }} rounded mb-2" 
                  href="{{ route('product') }}"
                >
                  <i class="bi bi-box me-2"></i>Products
                </a>
              </li>
              <li class="nav-item">
                <a 
                  href="{{ route('products.trashed') }}" 
                  class="btn btn-light d-flex align-items-center rounded mb-2 {{ Route::is('products.trashed') ? 'active' : '' }}"
                >
                  <img src="{{ asset('images/trash-bin.png') }}" alt="Recycle Bin" style="width: 24px; height: 24px; margin-right: 8px;">
                  Recycle Bin
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  
  





