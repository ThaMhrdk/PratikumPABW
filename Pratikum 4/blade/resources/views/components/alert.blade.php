@props(['type' => 'success', 'message' => ''])

<div style="padding: 15px;
            border: 2px solid {{ $type === 'error' ? '#e53935' : '#43a047' }};
            background: {{ $type === 'error' ? '#ffcdd2' : '#c8e6c9' }};
            border-radius: 10px;
            margin-bottom: 20px;
            color: {{ $type === 'error' ? '#b71c1c' : '#1b5e20' }};
            font-weight: 500;
            text-align: center;">
    {{ ucfirst($type) }}: {{ $message }}
</div>
