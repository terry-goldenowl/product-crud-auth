{{-- @props(['modal', 'form', 'method']) --}}

<div class="modal fade" id="{{ $modal }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="{{ $form }}" method="POST">
            @csrf
            @method($method)

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($method == 'post')
                        Create product
                    @else
                        Update product
                    @endif
                </h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-4">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-2">
                    <label for="name">Product name</label>
                    <input type="text" class="form-control" name="name"
                        id="name"placeholder="Enter product name">
                </div>
                <div class="form-group mt-2">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" name="price" id="price"
                        placeholder="Enter price">
                </div>
                <div class="form-group mt-2">
                    <label for="image">Image URL</label>
                    <input type="url" class="form-control" name="image" id="image" placeholder="Image URL">
                </div>
                <div class="form-group mt-2">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description"
                        placeholder="Describe about your product">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">
                    @if ($method == 'post')
                        Create product
                    @else
                        Update product
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>
