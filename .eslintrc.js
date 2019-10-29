module.exports = {
  root: true,
  env: {
    node: true
  },
  extends: ['plugin:vue/essential', '@vue/prettier'],
  rules: {
    eqeqeq: 'off',
    indent: 'off',
    'vue/script-indent': [
      'error',
      4,
      {
        baseIndent: 1
      }
    ],
    'vue/html-indent': [
      'error',
      4,
      {
        baseIndent: 1
      }
    ],
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off'
  },
  parserOptions: {
    parser: 'babel-eslint'
  }
}