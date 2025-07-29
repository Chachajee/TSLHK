<form id="contactForm" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
    @csrf
    <div class="row gy-4">

        <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            <div class="invalid-feedback" id="name-error"></div>
        </div>

        <div class="col-md-6">
            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
            <div class="invalid-feedback" id="email-error"></div>
        </div>

        <div class="col-md-12">
            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
            <div class="invalid-feedback" id="subject-error"></div>
        </div>

        <div class="col-md-12">
            <textarea class="form-control" name="message" rows="4" placeholder="Message" required></textarea>
            <div class="invalid-feedback" id="message-error"></div>
        </div>

        <div class="col-md-12 text-center">
            <div class="loading" style="display: none;">Loading</div>
            <div class="error-message" style="display: none;"></div>
            <div class="sent-message" style="display: none;">Your message has been sent. Thank you!</div>

            <button type="submit" id="submitBtn">Send Message</button>
        </div>

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const loading = form.querySelector('.loading');
    const errorMessage = form.querySelector('.error-message');
    const sentMessage = form.querySelector('.sent-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset previous states
        form.classList.remove('was-validated');
        loading.style.display = 'block';
        errorMessage.style.display = 'none';
        sentMessage.style.display = 'none';
        submitBtn.disabled = true;

        // Clear previous error messages
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

        const formData = new FormData(form);

        fetch('{{ route("contact.message.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            loading.style.display = 'none';
            submitBtn.disabled = false;

            if (data.success) {
                sentMessage.style.display = 'block';
                form.reset();
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    sentMessage.style.display = 'none';
                }, 5000);
            } else {
                errorMessage.textContent = data.message || 'An error occurred. Please try again.';
                errorMessage.style.display = 'block';
                
                // Hide error message after 5 seconds
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        })
        .catch(error => {
            loading.style.display = 'none';
            submitBtn.disabled = false;
            errorMessage.textContent = 'Network error. Please check your connection and try again.';
            errorMessage.style.display = 'block';
            
            // Hide error message after 5 seconds
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        });
    });
});
</script> 