var passwordChangeVerification = new Vue({
  el: '#passwordChangeVerification',
  data() {
    return {
      submitBttn: false,
      newPassword: '',
      reNewPassword: '',
      validations: {
        notNull: false,
        minLength: false,
        samePassword: false,
        minOneCapLetter: false,
        minOneSpecialSign: false
      }
    }
  },
  methods: {
    eventChange() {

      this.validatePasswords();

    },
    validate() {
      return this.validations.notNull && this.validations.minLength && this.validations.samePassword;
    },
    validatePasswords() {
      
      //not empty
      this.newPassword.length > 0 ? this.validations.notNull = true : this.validations.notNull = false;
      
      //longer than 7
      this.newPassword.length >= 8 ? this.validations.minLength = true : this.validations.minLength = false;
      
      //same passwords
      this.newPassword == this.reNewPassword ? this.validations.samePassword = true : this.validations.samePassword = false;
      
      //has one capital letter
      this.findCapLetter(this.newPassword,1) ? this.validations.minOneCapLetter = true : this.validations.minOneCapLetter = false;
      
      
      this.submitBttn = this.validate();

    },
    findCapLetter(password, nr) {
      return password.replace(/[a-z]/g, '').length >= nr;
    },
    findSpecialCharacter(password) {

    }
  }
});