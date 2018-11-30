var app = new Vue({
  el: '#app',
  data() {
    return {
      newPassword: '',
      reNewPassword: '',
      date_from: '',
      showFlash: true
    }
  },
  computed: {
    validated: function() {

      return this.oneCapLetter && this.oneSpecialChar && this.newPassword == this.reNewPassword && this.newPassword.length > 0;

    },
    oneCapLetter: function() {

      return this.newPassword.match(/[A-Z]/) ? true : false;

    },
    oneSpecialChar: function() {

      return this.newPassword.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/) ? true : false;

    }
  },
  methods: {
    refreshPage() {
      
      setTimeout(() => location.reload(), 3000);
      
    }
  },
  mounted: function() {

    setTimeout(() => this.showFlash = false, 3000);

  }
});