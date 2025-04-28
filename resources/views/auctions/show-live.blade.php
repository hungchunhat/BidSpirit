<x-layout>
    <section id="team" class="team">
        <div class="container section-title mb-3">
            <h2>LIVE Auction</h2>
            <p>Find and place your bids on the live auction</p>
        </div>
        <div class="container border-bottom border-secondary-subtle bg-white pb-3">
            <div class="row">
                <!-- Auction Information -->
                <div class="col-md-8">
                    <!-- Header -->
                    <div class="mb-4">
                        <h1 class="fs-4 fw-bold text-dark">
                            {{$auction->description}}
                        </h1>
                    </div>
                    <!-- Auction Details -->
                    <div class="mb-3">
                        <span class="fw-bold text-decoration-none">{{$auction->name}}</span> |
                        <span class="text-danger text-decoration-underline">Bid step: ${{$auction->bid_step}}</span>
                        <p class="mt-2 mb-0">
                            <span
                                class="fw-medium">Start time: {{\Carbon\Carbon::parse($auction->start_time)->format('l, M d, g:i A')}}</span><br>
                            <span
                                class="fw-medium">End time: {{\Carbon\Carbon::parse($auction->end_time)->format('l, M d, g:i A')}}</span><br>
                        </p>
                    </div>
                    <!-- Approval Button -->
                    @can('admin')
                        <div class="mb-4">
                            <button class="btn btn-outline-danger" form="start-auction">End this auction</button>
                        </div>
                        <form id="start-auction" method="post" action="{{route('auction.end',$auction->id)}}"
                              style="display: none">
                            @csrf
                            @method('PATCH')
                        </form>
                    @endcan
                </div>

                <!-- Auction Logo -->
                <div class="col-md-4 d-flex justify-content-md-end justify-content-center align-items-center">
                    <img src="/storage/{{$auction->image}}" alt="Auction's theme"
                         style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="alert alert-warning text-center">Your bid must be greater than the current price and the
                difference must be a multiple of bid step.
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Base Price($)</th>
                        <th>Current_Price($)</th>
                        <th>Detail</th>
                        @can('user')
                            <th>Place Bid</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td class="text-success fw-bold"
                                id="product{{$product->id}}">{{$product->bid->last()->bid_price??$product->price}}</td>
                            <td>
                                <!-- Button detail modal -->
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{$product->id}}">
                                    <i class="bi bi-info-circle"> Detail</i>
                                </button>
                            </td>

                            <!-- Modal -->
                            <div class="modal fade" id="detailModal{{$product->id}}" tabindex="-1"
                                 aria-labelledby="detailModal{{$product->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="detailModal{{$product->id}}Label">
                                                Product's detail</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <img src="/storage/{{$product->image}}" class="card-img-top"
                                                     alt="{{$product->name}}"
                                                     style="object-fit: cover; height: 300px;">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{$product->name}}</h5>
                                                    <p class="card-text">
                                                        <strong>Category:</strong> {{$product->category->name??''}}
                                                    </p>
                                                    <p class="card-text">{{$product->description??''}}</p>
                                                    <p class="card-text text-success fw-bold">
                                                        <strong>Price:</strong> ${{$product->price}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Button trigger placeBid modal -->
                            @can('user')
                                <td id="action{{$product->id}}">
                                    @php
                                        $lastBidUserId = $product->bid->last()?->user_id;
                                        $currentUserId = Auth::user()->id;
                                    @endphp
                                    @if($lastBidUserId === $currentUserId)
                                        <span id="placeBidAction-{{$product->id}}"
                                              class="d-inline-flex align-items-center text-success fw-bold">
                                        <i class="bi bi-check-circle"> Done</i>
                                    </span>
                                    @else
                                        <div id="placeBidAction-{{$product->id}}" class="row gx-2 align-items-center justify-content-center">
                                            <div class="col-12 col-sm" style="max-width: 200px; min-width: 100px">
                                                <input class="form-control" name="bid_price" type="number"
                                                       placeholder="Enter your bid price" id="input{{$product->id}}">
                                            </div>
                                            <div class="col-12 col-sm-auto mt-2 mt-sm-0">
                                                <button type="button"
                                                        class="btn btn-sm btn-warning w-100" data-bs-toggle="modal"
                                                        data-bs-target="#placeBidModal" data-bs-id="{{$product->id}}">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>

    <!-- placeBid Modal -->
    <div class="modal fade" id="placeBidModal" tabindex="-1"
         aria-labelledby="placeBidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"
                        id="placeBidModalLabel">Notification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to place a bid?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">No
                    </button>
                    <button type="button" class="btn btn-primary"
                            id="confirmYes">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-slot:script>
        <script type="module">
            @auth
            let id = null
            let input = null
            let placeBid = document.getElementById('placeBidModal');
            let modalBody = placeBid.querySelector('.modal-body');
            let confirmYes = document.getElementById('confirmYes');
            let btnClose = placeBid.querySelector('.btn-close');
            placeBid.addEventListener('show.bs.modal', (event) => {
                let button = event.relatedTarget;
                id = button.getAttribute('data-bs-id');
                input = document.getElementById('input' + id).value;
                console.log(id)
                console.log(input);
                confirmYes.disabled = false;
            });
            confirmYes.addEventListener('click', () => {
                confirmYes.disabled = true;
                let data = {
                    product_id: id,
                    user_bid: input,
                    bid_step: {{$auction->bid_step}},
                    auction_id: {{$auction->id}},
                    user_id: {{Auth::user()->id}}
                }
                console.log(data);
                axios.post("{{route('bids.store')}}", data)
                    .then((response) => {
                        console.log(response)
                        btnClose.click();
                    }).catch((error) => {
                    console.log(error);
                    btnClose.click();
                    alert('Bid failed, check your bid price and try again');
                    location.reload();
                })
            })
            @endauth
            Echo.channel('bidChange')
                .listen('BidInc', (e) => {
                    console.log('đây là sự kiện trả về:', e)
                    let IncPrice = document.getElementById('product' + e.product_id);
                    if (IncPrice) {
                        IncPrice.classList.remove('text-success');
                        IncPrice.innerHTML = e.bid_price;
                        IncPrice.classList.add('blink-red');
                        IncPrice.classList.add('text-success');
                        setTimeout(() => {
                            IncPrice.classList.remove('blink-red');
                        }, 300);
                    }
                    let parent = document.getElementById('action' + e.product_id);
                    let child = document.getElementById('placeBidAction-' + e.product_id);
                    @auth
                    if (e.user_id === {{Auth::user()->id}}) {
                        parent.removeChild(child)
                        let span = document.createElement('span');
                        span.innerHTML = '<i class="bi bi-check-circle"> Done</i>';
                        span.setAttribute('id', 'placeBidAction-' + e.product_id);
                        span.setAttribute('class', 'd-inline-flex align-items-center text-success fw-bold');
                        parent.appendChild(span)
                    }
                    else{
                        parent.removeChild(child);
                        let div = document.createElement('div');
                        div.setAttribute('class', 'row gx-2 align-items-center justify-content-center');
                        div.setAttribute('id', 'placeBidAction-' + e.product_id);
                        div.innerHTML = `
                        <div class="col-12 col-sm" style="max-width: 200px; min-width: 100px">
                            <input class="form-control" name="bid_price" type="number" placeholder="Enter your bid price" id="input${e.product_id}">
                        </div>
                        <div class="col-12 col-sm-auto mt-2 mt-sm-0">
                            <button type="button" class="btn btn-sm btn-warning w-100" data-bs-toggle="modal" data-bs-target="#placeBidModal" data-bs-id="${e.product_id}"><i class="bi bi-send"></i>
                            </button>
                        </div>`;
                        parent.appendChild(div);
                    }
                    @endauth
                })
        </script>
    </x-slot:script>

</x-layout>
