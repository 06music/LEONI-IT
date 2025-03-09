<template>
    <AdminLayout>
        <section class="bg-gray-50 dark:bg-gray-900 p-5">
            <div class="row">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-5 space-y-3 md:space-y-0">
                    <h2 class="text-xl font-semibold">Equipment Models</h2>
                    <div class="flex items-center space-x-3">
                        <el-input
                            v-model="searchQuery"
                            placeholder="Search for a model..."
                            class="w-64"
                            clearable
                        >
                            <template #prefix>
                                <el-icon><Search /></el-icon>
                            </template>
                        </el-input>
                        <el-button type="primary" @click="openModal(null)">
                            <el-icon><Plus /></el-icon> Add Model
                        </el-button>
                    </div>
                </div>

                <!-- Table Section -->
                <el-table :data="filteredModels" stripe highlight-current-row border style="width: 100%">
                    <el-table-column prop="name" label="Model Name" sortable />
                    <el-table-column prop="description" label="Description" sortable />
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
                        <el-form-item label="Model Name">
                            <el-input v-model="form.name" clearable placeholder="Enter model name" />
                        </el-form-item>
                        <el-form-item label="Description">
                            <el-input v-model="form.description" clearable placeholder="Enter description" />
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

const props = defineProps({ models: Array });

const showModal = ref(false);
const searchQuery = ref("");
const editingModelId = ref(null);

const form = useForm({
    name: "",
    description: "",
});

// Computed property for real-time filtering
const filteredModels = computed(() =>
    props.models.filter((model) =>
        model.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
);

const modalTitle = computed(() => (editingModelId.value ? "Edit Model" : "Add Model"));
const modalButton = computed(() => (editingModelId.value ? "Update" : "Save"));

const openModal = (model) => {
    if (model) {
        editingModelId.value = model.id;
        form.name = model.name;
        form.description = model.description;
    } else {
        editingModelId.value = null;
        form.reset();
    }
    showModal.value = true;
};

const submit = () => {
    if (editingModelId.value) {
        form.put(route("equipment-models.update", editingModelId.value), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Model updated successfully", type: "success" });
            },
        });
    } else {
        form.post(route("equipment-models.store"), {
            onSuccess: () => {
                showModal.value = false;
                ElMessage({ message: "Model added successfully", type: "success" });
            },
        });
    }
};

const confirmDelete = (id) => {
    ElMessageBox.confirm("Are you sure you want to delete this model?", "Warning", {
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        type: "warning",
    })
        .then(() => {
            form.delete(route("equipment-models.destroy", id), {
                onSuccess: () => ElMessage({ message: "Model deleted successfully", type: "success" }),
            });
        })
        .catch(() => {});
};
</script>
