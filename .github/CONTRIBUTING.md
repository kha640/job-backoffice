# Contributing to Job Board Platform

First off, thank you for considering contributing to the Job Board Platform! It's people like you that make open source such a great community.

## How Can I Contribute?

### Reporting Bugs
This section guides you through submitting a bug report. Following these guidelines helps maintainers and the community understand your report, reproduce the behavior, and find related reports.
* Use the provided `ISSUE_TEMPLATE.md` when creating an issue.
* Explain the problem and include additional details to help maintainers reproduce the problem.

### Suggesting Enhancements
This section guides you through submitting an enhancement suggestion, including completely new features and minor improvements to existing functionality.
* Use the `ISSUE_TEMPLATE.md`.
* Provide a clear and descriptive title and description.

### Pull Requests
* Fill in the required template `PULL_REQUEST_TEMPLATE.md`.
* Do not include issue numbers in the PR title.
* Include screenshots and animated GIFs in your pull request whenever possible.
* End files with a newline.

## Code Style

We follow the standard Laravel coding style. To ensure your code meets the standards, please format your code using **Laravel Pint** before submitting a pull request.

```bash
# In either job-app or job-backoffice
./vendor/bin/pint
```

If you are modifying the shared models package (`job-shared`), ensure that the code is also formatted according to the PSR-12 coding standard or using Pint if applicable.

## Testing

Please make sure to write feature tests for any new endpoints or features you add. You can run the existing tests via:

```bash
php artisan test
```

When writing tests that involve AI integrations (like Groq), make sure to mock the API calls so tests can pass without needing real API keys.
