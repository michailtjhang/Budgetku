<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-control select2" required>
        <option value="" disabled selected>Select Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" class="form-control" required>
</div>

<div class="form-group">
    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
</div>

<div class="form-group">
    <label for="type">Type</label>
    <select name="type" id="type" class="form-control select2" required>
        <option value="" disabled selected>Select Type</option>
        <option value="income">Income</option>
        <option value="expense">Expense</option>
    </select>
</div>
