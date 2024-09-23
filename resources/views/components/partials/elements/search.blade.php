<form>
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari ..." value="{{ $search ?? '' }}">
        <div class="input-group-btn">
            <button id="search-button" class="btn btn-primary" aria-label="Search">
                <i class="fas fa-search"></i>
                <span class="sr-only">Search</span>
            </button>
        </div>
    </div>
</form>
