# Smart Wage Management System - Feature Branch

**Branch Status**: Active Development  
**Current Focus**: Access Roles Implementation (75% complete)  
**Stable Version**: [Main Branch](https://github.com/rlyrvra/case-study/tree/main)

## Development Notice

⚠️ This is a feature development branch containing work-in-progress code.  
Features here are unstable and may change before merging with main.

## Current Development

### Active Features
- Access Roles System (75% complete)
  - Finalizing role-based permissions hierarchy
  - Testing permission boundaries between roles
  - Implementing UI restrictions based on roles

### Pending Testing


## Testing Guidelines

### Before testing:
1. Pull the latest changes
2. Request database from [rlyrvra] and [hannixminji]

### Known Considerations:
- Permission system may have incomplete UI restrictions
- Some admin functions might be temporarily exposed

## Quick Reference

| Section | Description |
|---------|-------------|
| Setup | Configure this branch |
| Test Data | Available testing accounts |
| API Changes | Modified endpoints |
| Reporting | How to report issues |

## Development Setup

1. Clone this branch:
   git clone -b feature/access-roles https://github.com/rlyrvra/smart-wage-management-system.git
   cd smart-wage-management-system

2. Install dependencies:
   composer install
   npm install

## Test Data

| Role        | Username | Password   | Permissions                  |
|-------------|----------|------------|------------------------------|
| Admin       | admin    | Admin#1234 | Full system access           |
| Manager     | b        | b          | Department-level access      |
| Supervisor  | c        | c          | Team-level access            |
| Staff       | d        | d          | Personal records only        |

## Bug Reports

Please include:
1. Branch name and commit hash
2. Test account used
3. Clear reproduction steps
4. Expected vs actual behavior
5. Relevant screenshots/logs
6. Document it [here](https://docs.google.com/spreadsheets/d/1KRxfwKuXND44HCCUnGmokcqtAjephycSbW-YoYDsDbo/edit?gid=1144752208#gid=1144752208)

Create new issue: https://github.com/rlyrvra/smart-wage-management-system/issues/new/choose


## Documentation

System Documentation: https://docs.google.com/document/d/1u0t_vbD5gFRzyKVPBoQUkYPwyvr3N0AZPwosvC8bzPc
API Specifications: https://example.com/api-docs (updated weekly)
Figma Designs: https://figma.com/team-project (UI reference)

## Team Contacts

| Role | Members | Focus Area |
|------|---------|------------|
| Backend | hannixminji | API, Database |
| Frontend | rlyrvra | Integration |
| UI/UX | Shiro-hr | Interfaces |
| UI/UX | vane404 | User Flows |
| UI/UX | carlbryandy | Visual Design |

## License

MIT License © 2023 Smart Wage Team

Note: This branch will be archived after merging to main. Refer to commit history for specific changes.