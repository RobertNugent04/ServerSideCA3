@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <!-- Row for movie poster -->
    <div class="row d-none d-md-block poster-row" style="background: url('https://image.tmdb.org/t/p/original/{{ $movie->backdrop_path }}') no-repeat center center; height:70vh; background-size:100% 100%"></div>

    <!-- Row for movie content -->
    <div class="row mb-4" style="background-color: #040012;">
        <div class="col-12 col-md-8">
            <!-- The movie card goes here -->
            <div class="card text-white" style="background-color: #040012; border:none;">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie->poster_path }}" class="card-img-top" alt="{{ $movie->title }}" style="width: 100%; object-fit:cover; margin-top: -50px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $movie->title }}</h5>
                            <p class="card-text">Year: {{ substr($movie->release_date, 0, 4) }}</p>
                            <p class="card-text">Rating: {{ $movie->vote_average }}</p>
                            <p class="card-text">Genres: 
                                @foreach($movie->genres as $genre)
                                    {{ $genre->name }}
                                @endforeach
                            </p>
                            <p class="card-text lh-lg">Overview: {{ $movie->overview }}</p>
                            <button type="button" class="btn btn-light text-dark btn-rating">Rating: {{ $movie->vote_average }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 other-content">
            <!-- Other content goes here -->
            <button class="btn btn-light mb-4 mt-2 text-dark btn-read-review">
                <i class="fas fa-comment-alt"></i> Read Review
            </button>
            <div id="review-section" class="mb-4 me-2" style="display: none; height: 300px; overflow-y: scroll;">
                @auth
                <form class="text-center mb-3 d-flex flex-column align-items-center" action="{{ route('reviews.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="movie_name" value="{{ $movie->title }}">
                    <textarea class="ms-2 mb-2 w-100 me-2" style="height: 100px" name="review" required>{{ __('  Make A Review') }}</textarea>
                    <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" name="rate" value="1" checked/>
                        <label for="star1" title="text">1 star</label>
                    </div>
                    <button class="btn btn-light text-dark" type="submit">Submit</button>
                </form>           
                @endauth
                <div id="reviews" class="d-flex flex-column">
                    <!-- Reviews will be loaded here -->
                    <h4 class="text-white text-center">Reviews</h4>
                    @if ($reviews->isEmpty())
                    <p class="text-white text-center">Currently no reviews</p>
                    @else
                    @foreach($reviews as $review)
                    <div class="card text-dark bg-light my-2 me-2">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $review->user->name }}</h5>
                                <div class="review-content" data-id="{{ $review->id }}">
                                    <p class="card-text">{{ $review->review }}</p>
                                    <div class="rate">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{$i}}-{{ $review->id }}" name="rate-{{ $review->id }}" value="{{ $i }}" {{ $i == $review->rating ? 'checked' : '' }} disabled/>
                                            <label for="star{{$i}}-{{ $review->id }}" title="text">{{ $i }} stars</label>
                                        @endfor
                                    </div> 
                                </div>
                            </div>
                            @if(auth()->id() == $review->user_id)
                                <div>
                                    <button class="btn btn-primary bg-dark mb-1 edit-review-btn" style="border: none" data-id="{{ $review->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button style="border: none" type="submit" class="btn btn-danger bg-dark delete-review-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                @endif
                </div>                
            </div>
            <a href="https://www.youtube.com/results?search_query={{ urlencode($movie->title . ' trailer') }}" target="_blank" class="btn btn-light mb-4 text-dark">
                <i class="fas fa-video"></i> Watch Trailer
            </a>            
            <a href="https://www.imdb.com/find?q={{ urlencode($movie->title) }}" target="_blank" class="btn btn-light mb-4 text-dark">
                <i class="fas fa-link"></i> View on IMDb
            </a>            
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
            </div>
            <form id="edit-review-form" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <textarea id="review-textarea" name="review" required class="w-100" style="height: 200px;"></textarea>
                    <div class="rate">
                        <input type="radio" id="modal-star5" name="rate" value="5" />
                        <label for="modal-star5" title="text">5 stars</label>
                        <input type="radio" id="modal-star4" name="rate" value="4" />
                        <label for="modal-star4" title="text">4 stars</label>
                        <input type="radio" id="modal-star3" name="rate" value="3" />
                        <label for="modal-star3" title="text">3 stars</label>
                        <input type="radio" id="modal-star2" name="rate" value="2" />
                        <label for="modal-star2" title="text">2 stars</label>
                        <input type="radio" id="modal-star1" name="rate" value="1" checked />
                        <label for="modal-star1" title="text">1 star</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-circle-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.querySelector('.btn-read-review').addEventListener('click', function() {
        const reviewSection = document.querySelector('#review-section');
        reviewSection.style.display = reviewSection.style.display === 'none' ? 'block' : 'none';
});


const editButtons = document.querySelectorAll('.edit-review-btn');
const deleteButtons = document.querySelectorAll('.delete-review-btn');
const editReviewModal = new bootstrap.Modal(document.getElementById('editReviewModal'), {});

editButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const reviewId = this.dataset.id;
        const reviewContent = document.querySelector(`.review-content[data-id="${reviewId}"] p`);
        const originalText = reviewContent.textContent;

        // Get the rating value
        const rating = document.querySelector(`input[name="rate-${reviewId}"]:checked`).value;

        // Hide the edit and delete buttons
        this.classList.add('hide');
        this.nextElementSibling.parentElement.classList.add('hide');

        // Set the form action
        document.getElementById('edit-review-form').action = "{{ url('reviews') }}/" + reviewId;

        // Set the textarea value
        document.getElementById('review-textarea').value = originalText;

        // Set the rating value
        document.getElementById(`modal-star${rating}`).checked = true;

        // Show the modal
        editReviewModal.show();
    });
});

// When the modal is hidden, show the edit and delete buttons again
$('#editReviewModal').on('hide.bs.modal', function (e) {
    editButtons.forEach(button => {
        button.classList.remove('hide');
        button.nextElementSibling.parentElement.classList.remove('hide');
    });
});
</script>

@endsection
