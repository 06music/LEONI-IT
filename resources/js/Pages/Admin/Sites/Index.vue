<template>
    <AdminLayout>
        <section class="bg-gray-50 dark:bg-gray-900 p-5">
            <div class="row">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
                    <h2 class="text-xl font-semibold">Sites Management</h2>
                    <div class="flex items-center space-x-3">
                        <el-input
                            v-model="searchQuery"
                            placeholder="Search for a site..."
                            class="w-64"
                            clearable
                        >
                            <template #prefix>
                                <el-icon><Search /></el-icon>
                            </template>
                        </el-input>
                        <el-button type="primary" @click="openModal(null)">
                            <el-icon><Plus /></el-icon> Add Site
                        </el-button>
                    </div>
                </div>

                <!-- Table Section -->
                <el-table :data="filteredSites" stripe highlight-current-row border style="width: 100%">
                    <el-table-column prop="name" label="Name" sortable />
                    <el-table-column prop="location" label="Location" sortable />
                    <el-table-column label="Actions" width="160">
                        <template #default="{ row }">
                            <el-tooltip content="Edit" placement="top">
                                <el-button size="small" @click="openModal(row)">
                                    <el-icon><Edit /></el-icon>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Delete" placement="top">
                                <el-button size="small" type="danger" @click="confirmDelete(row.id)">
                                    <el-icon><Delete /></el-icon>
                                </el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>

                <!-- Modal Popup for Add/Edit -->
                <el-dialog v-model="showModal" :title="modalTitle" width="450px" center>
                    <el-form :model="form" label-width="100px">
                        <el-form-item label="Name">
                            <el-input v-model="form.name" clearable placeholder="Enter site name" />
                        </el-form-item>
                        <el-form-item label="Location">
                            <el-input v-model="form.location" clearable placeholder="Enter location" />
                        </el-form-item>
                    </el-form>
                    <template #footer>
                        <el-button @click="showModal = false">Cancel</el-button>
                        <el-button type="primary" @click="submit">{{ modalButton }}</el-button>
                    </template>
                </el-dialog>
            </div>
        </section>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { ElMessage, ElMessageBox } from "element-plus";
import AdminLayout from "../Components/AdminLayout.vue";
import { Search, Plus, Edit, Delete } from "@element-plus/icons-vue";

const props = defineProps({ sites: Array });

const showModal = ref(false);
const searchQuery = ref("");
const editingSiteId = ref(null);

const form = useForm({
    name: "",
    location: "",
});

// Computed property for real-time filtering
const filteredSites = computed(() =>
    props.sites.filter(
        (site) =>
            site.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            site.location.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
);

const modalTitle = computed(() => (editingSiteId.value ? "Edit Site" : "Add Site"));
const modalButton = computed(() => (editingSiteId.value ? "Update" : "Save"));

const openModal = (site) => {
    if (site) {
        editingSiteId.value = site.id;
        form.name = site.name;
        form.location = site.location;
    } else {
        editingSiteId.value = null;
        form.reset();
    }
    showModal.value = true;
};

const submit = () => {
    if (editingSiteId.value) {
        form.put(route("sites.update", editingSiteId.value), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Site updated successfully", type: "success" });
            },
        });
    } else {
        form.post(route("sites.store"), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Site added successfully", type: "success" });
            },
        });
    }
};

const confirmDelete = (id) => {
    ElMessageBox.confirm("Are you sure you want to delete this site?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    })
        .then(() => {
            form.delete(route("sites.destroy", id), {
                onSuccess: () => ElMessage({ message: "Site deleted successfully", type: "success" }),
            });
        })
        .catch(() => {});
};
</script>

<style>
/* Optional Styling for Better UX */
.el-dialog {
    border-radius: 12px !important;
}
</style>
