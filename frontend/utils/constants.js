var Constants = {
  get_api_base_url: function () {
    if(location.hostname == 'localhost'){
      // must be hardcoded ?
      return "http://localhost:80/finalWeb/backend/rest";
    } else {
      return "";
    }
  }
};