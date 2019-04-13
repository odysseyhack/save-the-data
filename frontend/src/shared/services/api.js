import axios from "axios";

export default {
  upload(file) {
    let formData = new FormData();
    formData.append("photo", file);

    return axios
      .post("https://api.firesync.online/upload", formData, {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      })
    }
};
