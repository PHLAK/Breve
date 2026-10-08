# Contributing to Breve

Contributions are **welcome** via Pull Requests on [GitHub](https://github.com/PHLAK/Breve).

**Before contributing** we encourage you to discuss the change in
[GitHub Discussion](https://github.com/PHLAK/Breve/discussions)
to verify fit with the overall direction and goals of Breve.

## Pull Requests Requirements

- **One feature per pull request.** If you want to change more than one thing,
  send multiple pull requests.

- **[PSR-2 Coding Standard.](https://www.php-fig.org/psr/psr-2/)** The easiest
  way to apply the conventions is to install and run
  [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

- **Test all the tings!** Your patch won't be accepted if it doesn't have tests.

- **Document changes in behaviour.** Make sure relevant documentation is kept
  up to date.

## Checking Your Work

Please check your work before submitting. Your branch must meet our coding
standards and pass static analysis and tests before it will be accepted.

### Coding Standards

You can check your code formatting without applying any fixes by running

    composer exec php-cs-fixer fix --diff --dry-run

To automatically apply any fixes run the same command without the flags.

    composer exec php-cs-fixer fix

### Static Analysis

[PHPStan](https://phpstan.org) is used to generate a report of static analysis
errors. To check your code for static analysis errors run

    composer exec phpstan

### Run Tests

Application tests can be ran with phpunit.

    composer exec phpunit

## AI Policy

Breve has strict rules for AI usage:

  - **All AI usage MUST be disclosed.** The tools (e.g. Claude Code, GitHub
    Copilot, etc.) used and the extent of the AI assistance must be clearly
    stated in advanced.
  - **All code MUST be fully understood by a human.** That human should have an
    understanding of the intention and reason for all submitted code changes and
    be able to defend their position with reason upon request.
  - **AI MAY be used in issues and discussions with a human filter.** AI is
    often overly verbose and wrong. Any AI generated comments must be reviewed
    and edited for accuracy and brevity by a human prior to submission.

> [!NOTE] These rules only apply to outside contributions. Maintainers are
> exempt from these rules and may use AI tools at their discretion.

### AI _Assisted_ Contributions are Welcome

In summary, AI is welcome here as long as it's understood that AI is a tool for
humans to weild and _not a replacement for humans_. Qualified individuals can
make meaningful contributions with or without AI and we don't wish to disuade
those that use AI from contributing. That being said, AI is increasingly being
used by _unqualified individuals_ to make contributions they do not understand.
It's for this reason we have decided to enact this AI policy.

---

*Thank you and happy coding!*
