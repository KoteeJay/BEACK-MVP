<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Comment Notification</title>
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f3f4f6;
      color: #111827;
      margin: 0;
      padding: 0;
    }
    .email-wrapper {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .header {
      background: linear-gradient(to right, #1e3a8a, #2563eb);
      color: #fff;
      text-align: center;
      padding: 30px 20px;
    }
    .header h1 {
      font-size: 22px;
      margin: 0;
      font-weight: 600;
    }
    .body {
      padding: 30px 25px;
      font-size: 16px;
      line-height: 1.6;
    }
    .body h2 {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 12px;
    }
    .comment-box {
      background-color: #f9fafb;
      border-left: 4px solid #3b82f6;
      padding: 12px 15px;
      margin: 16px 0;
      border-radius: 8px;
    }
    .button {
      display: inline-block;
      background-color: #2563eb;
      color: #fff !important;
      text-decoration: none;
      padding: 12px 22px;
      border-radius: 8px;
      font-weight: 500;
      margin-top: 20px;
      transition: background-color 0.2s ease;
    }
    .button:hover {
      background-color: #1e40af;
    }
    .footer {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      padding: 25px;
      border-top: 1px solid #e5e7eb;
      background-color: #f9fafb;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="header">
      <h1>💬 New Comment on Your Post</h1>
    </div>
    <div class="body">
      <h2>Hello {{ $comment->post->user->name }},</h2>
      <p>
        You just received a new comment on your post:
        <strong>{{ Str::limit($comment->post->title ?? $comment->post->body, 60) }}</strong>
      </p>
      <p><strong>{{ $comment->user->name }}</strong> wrote:</p>

      <div class="comment-box">
        {{ $comment->body }}
      </div>

      <p>
        You can view and reply to this comment by visiting your post.
      </p>

      <a href="{{ route('posts.show', $comment->post->slug) }}" class="button">
        View Post →
      </a>

      <p style="margin-top: 30px;">
        Thank you for sharing your thoughts on {{ config('app.name') }}!
      </p>
    </div>

    <div class="footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
      This is an automated notification — please do not reply directly.
    </div>
  </div>
</body>
</html>
