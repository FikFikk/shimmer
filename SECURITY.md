# Security

## Reporting Vulnerability

Don't report in public issues. Send email to **fikfikk14@gmail.com**

Include:

- Vulnerability description
- Steps to reproduce
- Impact

Response: 1-3 days

## Best Practices

- Always validate user input
- Use HTTPS for images
- Escape user data with `{{ }}` not `{!! !!}`

```php
// ✅ Good
$validated = request()->validate(['image' => 'image|max:2048']);

// ❌ Bad
shimmer_image($_GET['image']); // Never!
```

Contact: **fikfikk14@gmail.com**
