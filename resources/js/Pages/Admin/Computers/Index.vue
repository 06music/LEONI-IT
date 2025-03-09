<template>
    <AdminLayout>
      <section class="bg-gray-50 dark:bg-gray-900 p-5">
        <div class="row">
          <!-- Header Section -->
          <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
            <h2 class="text-xl font-semibold">Computers Management</h2>
            <div class="flex items-center space-x-3">
              <el-input v-model="searchQuery" placeholder="Search for a computer..." class="w-64" clearable>
                <template #prefix>
                  <el-icon><Search /></el-icon>
                </template>
              </el-input>

              <!-- Excel Upload Button -->
              <input type="file" @change="handleFileUpload" accept=".xls,.xlsx" class="hidden" ref="fileInput" />
              <el-button type="primary" @click="triggerFileInput" :loading="form.processing">
                <el-icon><Upload /></el-icon> Upload Excel
              </el-button>
            </div>
          </div>

          <!-- Upload Progress -->
          <el-progress v-if="uploadProgress > 0" :percentage="uploadProgress" status="success" />

          <!-- Table Section -->
          <el-table :data="paginatedComputers" stripe highlight-current-row border style="width: 100%">
            <el-table-column prop="computer_name" label="Computer Name" sortable />
            <el-table-column prop="operating_system" label="Operating System" sortable />
            <el-table-column prop="model" label="Model" sortable />
            <el-table-column prop="mac_address" label="MAC Address" sortable />
            <el-table-column prop="ip_address" label="IP Address" sortable />
            <el-table-column prop="disk_size" label="Disk Size" sortable />
            <el-table-column prop="ram" label="RAM" sortable />
            <el-table-column prop="serial_number" label="Serial Number" sortable />
            <el-table-column prop="site.name" label="Site" sortable />
          </el-table>

          <!-- Pagination -->
          <div class="flex justify-end mt-5">
            <el-pagination
              background
              layout="prev, pager, next"
              :total="filteredComputers.length"
              :page-size="pageSize"
              @current-change="handlePageChange"
            />
          </div>
        </div>
      </section>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage } from "element-plus";
import AdminLayout from "../Components/AdminLayout.vue";
import { Search, Upload } from "@element-plus/icons-vue";

// Props
const props = defineProps({
    computers: Array,
});

// Reactive variables
const searchQuery = ref("");
const currentPage = ref(1);
const pageSize = 20;
const uploadProgress = ref(0);
const fileInput = ref(null);

// Inertia Form for file upload
const form = useForm({
    file: null,
});

// Function to trigger file input click
const triggerFileInput = () => fileInput.value.click();

// Handle File Upload
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (!file.name.endsWith(".xls") && !file.name.endsWith(".xlsx")) {
        ElMessage.error("Only Excel files (.xls, .xlsx) are allowed.");
        return;
    }

    form.file = file;
    uploadExcel();
};

// Upload Excel function
const uploadExcel = () => {
    form.post("/admin/computers/upload-excel", {
        preserveScroll: true,
        onSuccess: () => {
            ElMessage.success("Excel file uploaded successfully.");
        },
        onError: (errors) => {
            console.error("Upload error:", errors);
            ElMessage.error("Failed to upload Excel file. Check server logs.");
        },
        onProgress: (progress) => {
            uploadProgress.value = progress.percentage;
        },
    });
};

// Computed properties
const filteredComputers = computed(() =>
    props.computers.filter((computer) =>
        [computer.computer_name, computer.operating_system, computer.model, computer.mac_address]
            .some((field) => field?.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
);

const paginatedComputers = computed(() =>
    filteredComputers.value.slice((currentPage.value - 1) * pageSize, currentPage.value * pageSize)
);

// Pagination
const handlePageChange = (page) => (currentPage.value = page);
</script>
