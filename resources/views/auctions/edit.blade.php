<x-layout>
    <section id="team" class="team">
        <div class="container section-title mb-5">
            <h2>Upcoming Auction</h2>
            <p>Explore and get ready to bid on the upcoming auction!</p>
        </div>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form method="post" action="{{route('auction.update',$auction->id)}}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="auctionName" class="form-label">Auction Name</label>
                    <input type="text" class="form-control" id="auctionName" name="name"
                           placeholder="Enter auction name" value="{{$auction->name}}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                              placeholder="Enter description">{{$auction->description}}</textarea>
                </div>
                <div class="mb-3">
                    <label for="startTime" class="form-label">Start Time</label>
                    <input type="datetime-local" class="form-control" id="startTime"
                           name="start_time" value="{{$auction->start_time}}">
                </div>
                <div class="mb-3">
                    <label for="endTime" class="form-label">End Time</label>
                    <input type="datetime-local" class="form-control" id="endTime"
                           name="end_time" value="{{$auction->end_time}}">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="normal" selected>Normal</option>
                        <option value="sponsored">Sponsored</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bidStep" class="form-label">Bid Step</label>
                    <input type="number" class="form-control" id="bidStep" name="bid_step"
                           placeholder="Enter bid step" value="{{$auction->bid_step}}">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image"
                           accept="image/*">
                </div>
                <div class="mb-3">
                    <div id="image-preview" class="mt-2"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    <x-slot:script>
        <script type="module">
            document.getElementById('image').addEventListener('change', function (event) {
                const imagePreview = document.getElementById('image-preview');
                imagePreview.innerHTML = "";
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = "Preview Image";
                        img.style.maxWidth = "100%";
                        img.style.height = "auto";
                        imagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </x-slot:script>
</x-layout>
