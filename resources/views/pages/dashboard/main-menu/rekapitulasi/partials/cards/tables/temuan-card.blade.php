<section>
    <div class="card">
        <div class="card-header">
            <h4>Tabel Temuan</h4>
            <div class="card-header-action">
                <button type="button" class="btn btn-sm btn-primary export-table"><i class="fas fa-file-excel"></i>
                    Eksport</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <x-partials.tables.temuan-table :data="$data" />
            </div>
        </div>
    </div>
</section>
