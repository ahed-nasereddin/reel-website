<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-8">Request a Quotation</h2>
      <form @submit.prevent="submitQuotation" class="bg-white rounded-xl shadow-md p-8 space-y-6">
        
        <!-- User Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input
            v-model="form.name"
            type="text"
            placeholder="Your Name "
            required
            class="border rounded-md p-3 w-full"
          />
          <input
            v-model="form.company_name"
            type="text"
            placeholder="Your Company Name"
            required
            class="border rounded-md p-3 w-full"
          />
          <input
            v-model="form.email"
            type="email"
            placeholder="Email"
            required
            class="border rounded-md p-3 w-full"
          />
          <input
            v-model="form.mobile"
            type="tel"
            placeholder="Mobile Number"
            required
            class="border rounded-md p-3 w-full"
          />
          <input
            v-model="form.days"
            type="number"
            placeholder="Number of Days"
            min="1"
            required
            class="border rounded-md p-3 w-full"
          />
        </div>

        <!-- Optional Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input
            v-model="form.pickupDate"
            type="datetime-local"
            placeholder="Pickup Date & Time"
            class="border rounded-md p-3 w-full"
          />
          <input
            v-model="form.location"
            type="text"
            placeholder="Delivery Location"
            class="border rounded-md p-3 w-full"
          />
        </div>

        <!-- Equipment Requests -->
        <div class="space-y-4">
          <h3 class="text-xl font-semibold">Equipment Needed</h3>
          <div
            v-for="(item, index) in form.equipments"
            :key="index"
            class="flex gap-4 items-center"
          >
            <input
              v-model="item.name"
              type="text"
              placeholder="Equipment Name"
              class="border rounded-md p-2 flex-1"
              required
            />
            <input
              v-model="item.count"
              type="number"
              placeholder="Quantity"
              min="1"
              class="border rounded-md p-2 w-24"
              required
            />
            <input
              v-model="item.note"
              type="text"
              placeholder="Note"
              class="border rounded-md p-2 flex-1"
            />
            <button
              type="button"
              @click="removeEquipment(index)"
              class="text-red-500 hover:text-red-700"
            >
              &times;
            </button>
          </div>
          <button
            type="button"
            @click="addEquipment"
            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/80 transition"
          >
            + Add Equipment
          </button>
        </div>

        <!-- Special Requests -->
        <textarea
          v-model="form.notes"
          placeholder="Special Requests / Comments"
          class="border rounded-md p-3 w-full"
        ></textarea>
        <div v-if="message" class="mb-4 p-3 rounded bg-green-100 text-green-800">
          {{ message }}
        </div>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="submit"

          class="bg-primary text-white px-6 py-3 rounded-md hover:bg-primary/90  transition w-full"
        >
          <span v-if="!submit">Submit Quotation</span>
          <span v-else>submiting..</span>
        </button>
      </form>
    </div>
  </section>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";
const form = reactive({
  name: "",
  company_name:"",
  email: "",
  mobile: "",
  days: 1,
  pickupDate: "",
  location: "",
  equipments: [
    { name: "", count: 1, note: "" }
  ],
  notes: ""
});
const resetForm = () => {
  form.name = "";
  form.company_name = "";
  form.email = "";
  form.mobile = "";
  form.days = 1;
  form.pickupDate = "";
  form.location = "";
  form.equipments = [{ name: "", count: 1, note: "" }];
  form.notes = "";
};
const submit=ref<boolean>(false);
const message=ref<string>('');
const addEquipment = () => {
  form.equipments.push({ name: "", count: 1, note: "" });
};

const removeEquipment = (index:number) => {
  form.equipments.splice(index, 1);
};

const submitQuotation = async() => {

  // TODO: send `form` to your Laravel API using axios
  try {
    submit.value=true;
      const formData = new FormData();
  formData.append('name', form.name);
  formData.append('company_name', form.company_name);
  formData.append('email', form.email);
  formData.append('mobile', form.mobile);
  formData.append('no_days', String(form.days));
  formData.append('pickup_date', form.pickupDate);
  formData.append('location', form.location);
  // append equipments (array of objects)
  form.equipments.forEach((item, index) => {
    formData.append(`equipments[${index}][name]`, item.name);
    formData.append(`equipments[${index}][count]`, String(item.count));
    formData.append(`equipments[${index}][note]`, item.note);
  });

    formData.append('notes', form.notes);
      console.log("Quotation Data:", JSON.parse(JSON.stringify(formData)));
   const response=await axios.post('/api/makequote',formData, {
    headers: {
      "Content-Type": "multipart/form-data",
    },
  });
      // ✅ clear the form
    resetForm();
   // ✅ show backend message
    message.value = response.data.message;
   
  } catch (error:any) {
    
     if (error.response) {
      console.error("Error Response:", error.response.data);
      message.value = error.response.data.message || "Something went wrong";
    } else if (error.request) {
      console.error("No Response:", error.request);
      message.value = "No response from server";
    } else {
      console.error("Error Message:", error.message);
      message.value = "Request error: " + error.message;
    }
  }finally{
     submit.value=false;
  }
};
</script>

<style scoped>
/* optional hover effect for buttons */
button:hover {
  cursor: pointer;
}
</style>
