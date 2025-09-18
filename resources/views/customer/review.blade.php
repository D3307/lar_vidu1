@extends('layouts.app')

@section('content')
    <div class="review-form">
        <h3>Đánh giá đơn hàng #{{ $order->id }}</h3>

        <form action="{{ route('reviews.store', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="rating">Số sao</label>
                <div class="star-rating">
                    <input type="hidden" name="rating" id="rating" value="0">
                    <span class="star" data-value="1">★</span>
                    <span class="star" data-value="2">★</span>
                    <span class="star" data-value="3">★</span>
                    <span class="star" data-value="4">★</span>
                    <span class="star" data-value="5">★</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="comment">Bình luận</label>
                <textarea name="comment" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>
    </div>

    <style>
        /* Container form đánh giá */
        .review-form {
            max-width: 600px;
            margin: 30px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .review-form h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        /* Input đẹp */
        .review-form .form-control,
        .review-form select,
        .review-form textarea {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 12px;
            transition: all 0.3s ease;
        }

        .review-form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.25);
        }

        /* Button */
        .review-form button {
            background: linear-gradient(135deg, #e75480, #ff9bb5);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 15px;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(231, 84, 128, 0.3);
        }

        .review-form button:hover {
            background: linear-gradient(135deg, #d43d6c, #ff7b9c);
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(231, 84, 128, 0.4);
        }

        /* Toast notification */
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 280px;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
            animation: slideIn 0.5s ease;
            color: #fff;
        }

        .custom-toast.success {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .custom-toast.error {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .custom-toast .icon {
            font-size: 18px;
        }

        .custom-toast .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #fff;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }

        .star-rating {
            font-size: 32px;
            color: #ddd; /* màu xám nhạt mặc định */
            cursor: pointer;
            display: flex;
            gap: 6px;
        }

        .star {
            transition: color 0.2s ease;
        }

        .star.hover,
        .star.selected {
            color: #e75480; /* hồng chủ đạo giao diện */
        }
    </style>


    <script>
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingInput = document.getElementById('rating');
        let selectedValue = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', function () {
                let value = this.getAttribute('data-value');

                // tô sáng sao khi hover
                stars.forEach(s => {
                    s.classList.remove('hover');
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('hover');
                    }
                });
            });

            star.addEventListener('mouseout', function () {
                // reset hover, giữ lại selected
                stars.forEach(s => s.classList.remove('hover'));
                if (selectedValue > 0) {
                    stars.forEach(s => {
                        if (s.getAttribute('data-value') <= selectedValue) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                }
            });

            star.addEventListener('click', function () {
                selectedValue = this.getAttribute('data-value');
                ratingInput.value = selectedValue;

                // tô sáng theo selected
                stars.forEach(s => {
                    s.classList.remove('selected');
                    if (s.getAttribute('data-value') <= selectedValue) {
                        s.classList.add('selected');
                    }
                });
            });
        });
    </script>
@endsection