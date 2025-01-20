<div class="modal fade" id="modalCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Please Enter Category Name" value="{{ old('name') }}">
                        <small class="form-text text-muted">
                            *Masukkan nama yang jelas dan deskriptif untuk memudahkan pemahaman.*
                        </small>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="description">Category Type</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="radio" name="type" value="1" id="typeIncome"
                                    class="@error('type') is-invalid @enderror"
                                    {{ old('type') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="typeIncome">Income (Pemasukan)</label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" name="type" value="0" id="typeExpense"
                                    class="@error('type') is-invalid @enderror">
                                <label class="form-check-label" for="typeExpense">Expense (Pengeluaran)</label>
                            </div>
                        </div>

                        <small class="form-text text-muted">
                            *Pilih salah satu kategori: "Income (Pemasukan)" jika kategori ini terkait pemasukan, atau
                            "Expense (Pengeluaran)" jika terkait pengeluaran.*
                        </small>

                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="icon">Category Icon Class (Font Awesome)</label>
                        <input type="text" name="icon" id="icon"
                            class="form-control @error('icon') is-invalid @enderror" placeholder="e.g., fas fa-star"
                            value="{{ old('icon') }}">
                            
                        <small class="form-text text-muted">
                            *Masukkan nama class ikon Font Awesome. Contoh: "fas fa-star" untuk ikon bintang.*
                        </small>

                        @error('icon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
