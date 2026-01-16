# Contributing

Thanks for contributing! 🎉

## How to Contribute

### Reporting Bugs

Create an [issue](https://github.com/fikfikk/shimmer/issues) with:

- Bug description
- Steps to reproduce
- Expected vs actual result
- Laravel & PHP version

### Feature Requests

Create an issue with your feature description.

## Pull Requests

1. Fork repo
2. Create branch: `git checkout -b feature/your-feature`
3. Commit: `git commit -m 'Add feature'`
4. Push: `git push origin feature/your-feature`
5. Create PR

---

## Pull Request Process

### Before Submitting

- ✅ Test your changes thoroughly
- ✅ Update documentation if needed
- ✅ Follow coding standards
- ✅ Write clear commit messages
- ✅ Ensure no merge conflicts

### Submitting

1. **Push to your fork**

   ```bash
   git push origin feature/my-new-feature
   ```

2. **Create Pull Request**

   - Go to the original repository
   - Click "New Pull Request"
   - Select your branch
   - Fill out the PR template

3. **PR Template**

   ```markdown
   ## Description

   Brief description of changes.

   ## Type of Change

   - [ ] Bug fix
   - [ ] New feature
   - [ ] Documentation update
   - [ ] Code refactoring
   - [ ] Performance improvement

   ## Related Issues

   Fixes #123

   ## Testing

   How did you test this?

   ## Screenshots (if applicable)

   Add screenshots here.

   ## Checklist

   - [ ] Code follows style guidelines
   - [ ] Self-reviewed the code
   - [ ] Commented complex code
   - [ ] Updated documentation
   - [ ] No new warnings
   - [ ] Tests added/updated
   - [ ] All tests pass
   ```

4. **Wait for review**

   - Maintainers will review your PR
   - Address any feedback
   - Make requested changes
   - PR will be merged when approved

---

## Coding Standards

### PHP Code Style

Follow PSR-12 coding standards:

```php
<?php

namespace Fikfikk\Shimmer;

use Illuminate\Support\ServiceProvider;

class ExampleClass
{
    /**
     * DocBlock for all methods.
     */
    public function exampleMethod(string $param): void
    {
        // Code here
    }
}
```

### JavaScript Code Style

```javascript
// Use modern ES6+ syntax
const FikfikkShimmer = {
  init() {
    // Code here
  },

  create(options) {
    // Code here
  },
};
```

### CSS Code Style

```css
/* Use clear, descriptive class names */
.shimmer-container {
  position: relative;
  overflow: hidden;
}

/* Use CSS variables for theming */
:root {
  --shimmer-base: #e0e0e0;
  --shimmer-color: #f0f0f0;
}
```

---

## Commit Messages

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding/updating tests
- `chore`: Maintenance tasks

### Examples

```bash
# Good commit messages
feat(blade): add support for custom aspect ratios
fix(js): resolve image loading detection issue
docs(readme): add Vue.js integration example
style(css): improve dark mode colors
refactor(helpers): simplify shimmer_image function
test(component): add unit tests for ImageShimmer
chore(deps): update Laravel dependency to ^11.0

# Bad commit messages
❌ fixed bug
❌ update
❌ WIP
❌ asdfasdf
```

---

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run specific test
composer test -- --filter=testExampleMethod

# With coverage
composer test-coverage
```

### Writing Tests

```php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Fikfikk\Shimmer\View\Components\ImageShimmer;

class ImageShimmerTest extends TestCase
{
    /** @test */
    public function it_renders_with_required_props(): void
    {
        $component = new ImageShimmer(src: 'test.jpg');

        $this->assertEquals('test.jpg', $component->src);
        $this->assertEquals('16/9', $component->aspectRatio);
    }
}
```

---

## Additional Notes

### File Structure

```
shimmer-package/
├── src/
│   ├── ShimmerServiceProvider.php    # Service provider
│   ├── View/Components/              # Blade components
│   ├── Facades/                      # Facades
│   ├── config/                       # Configuration
│   └── helpers.php                   # Helper functions
├── resources/views/                  # Blade views
├── dist/                             # Compiled CSS/JS
├── tests/                            # Tests
└── docs/                             # Documentation
```

### Need Help?

- 💬 [GitHub Discussions](https://github.com/fikfikk/shimmer/discussions)
- 📧 Email: fikfikk14@gmail.com
- 🐛 [Report Issues](https://github.com/fikfikk/shimmer/issues)

---

## Recognition

Contributors will be recognized in:

- README.md credits section
- Release notes
- GitHub contributors page

---

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing! 🎉❤️
