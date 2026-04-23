console.log("CRUD JS Loaded Successfully!");

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


function performStore(url, data) {
    axios.post(url, data)
        .then(function (response) {
            Swal.fire({
                icon: response.data.icon || 'success',
                title: response.data.title || 'تم الحفظ!',
                text: response.data.text || response.data.message,
                showConfirmButton: false,
                timer: 1500
            });
            // توجيه ديناميكي حسب الرابط القادم من الكنترولر
            if (response.data.redirect) {
                setTimeout(() => { window.location.href = response.data.redirect; }, 1500);
            }
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: error.response.data.message
            });
        });
}

function performUpdate(url, data) {
    data._method = 'PUT'; 
    axios.post(url, data)
        .then(function (response) {
            Swal.fire({
                icon: response.data.icon || 'success',
                title: response.data.title || 'تم التعديل!',
                text: response.data.text || response.data.message,
                showConfirmButton: false,
                timer: 1500
            });
            // توجيه ديناميكي
            if (response.data.redirect) {
                setTimeout(() => { window.location.href = response.data.redirect; }, 1500);
            }
        })
        .catch(function (error) {
            Swal.fire({ 
                icon: 'error', 
                title: 'فشل التحديث', 
                text: error.response.data.message 
            });
        });
}

function confirmDestroy(url, reference) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لا يمكن التراجع عن هذه الخطوة بسهولة!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(url)
                .then(function (response) {
                    Swal.fire({
                        icon: response.data.icon || 'success',
                        title: response.data.title || 'تم الحذف!',
                        text: response.data.message || response.data.text,
                    });
                    reference.closest('tr').remove(); 
                })
                .catch(function (error) {
                    Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف', 'error');
                });
        }
    })
}

function confirmRestore(url, reference) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "سيتم إعادة المهمة للقائمة الرئيسية!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، استرجعها!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            performRestore(url, reference);
        }
    })
}

function performRestore(url, reference) {
    axios.post(url)
        .then(function (response) {
            Swal.fire({
                icon: response.data.icon || 'success',
                title: response.data.title || 'تم الاسترجاع!',
                text: response.data.text || response.data.message,
                showConfirmButton: false,
                timer: 1500
            });
            reference.closest('tr').remove();
        })
        .catch(function (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'خطأ 404',
                text: 'الرابط غير صحيح أو المهمة غير موجودة'
            });
        });
}

function updateProfileImage(input) {
    if (input.files && input.files[0]) {
        let file = input.files[0];
        let formData = new FormData();
        formData.append('profile_image', file);
        let url = '/update-avatar';

        axios.post(url, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح!',
                text: 'تم تحديث الصورة الشخصية بنجاح.',
                showConfirmButton: false,
                timer: 2000
            });

            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('sidebar_profile_image').src = e.target.result;
            }
            reader.readAsDataURL(file);
        })
        .catch(function (error) {
            let errorMessage = 'حدث خطأ غير معروف في السيرفر';
            if (error.response && error.response.data) {
                errorMessage = error.response.data.message || error.response.statusText;
            }
            Swal.fire({ icon: 'error', title: 'تفاصيل الخطأ:', text: errorMessage, confirmButtonText: 'حسناً' });
        });
        input.value = '';
    }
}

function showImageOptions(event) {
    event.preventDefault(); 
    let currentImageUrl = document.getElementById('sidebar_profile_image').src;

    Swal.fire({
        title: 'ماذا تريد أن تفعل؟',
        showCancelButton: true,
        showDenyButton: true,
        showCloseButton: true,
        confirmButtonText: '<i class="fas fa-camera"></i> إرفاق',
        denyButtonText: '<i class="fas fa-eye"></i> عرض',
        cancelButtonText: '<i class="fas fa-trash"></i> حذف',
        confirmButtonColor: '#28a745', 
        denyButtonColor: '#007bff', 
        cancelButtonColor: '#dc3545', 
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('upload_new_image').click();
        } else if (result.isDenied) {
            window.open(currentImageUrl, '_blank');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            deleteProfileImage();
        }
    });
}

function deleteProfileImage() {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "سيتم حذف صورتك والعودة للصورة الافتراضية!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذفها!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete('/delete-avatar')
                .then(function (response) {
                    Swal.fire('تم الحذف!', 'تم إزالة صورتك الشخصية.', 'success');
                    document.getElementById('sidebar_profile_image').src = '/cms/dist/img/user2-160x160.jpg'; 
                })
                .catch(function (error) {
                    Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف', 'error');
                });
        }
    });
}

function addNewEvent() {
    Swal.fire({
        title: 'تفاصيل الحدث الجديد',
        html:
            '<label>عنوان الحدث</label>' +
            '<input id="swal-input1" class="swal2-input" placeholder="عنوان الحدث">' +
            '<label>اختر التاريخ</label>' +
            '<input id="swal-input2" type="date" class="swal2-input">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'حفظ الحدث',
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value
            ]
        }
    }).then((result) => {
        if (result.value) {
            const [title, date] = result.value;
            if (title && date) {
                Swal.fire('تم الحفظ!', `تمت إضافة ${title} في تاريخ ${date}`, 'success');
            } else {
                Swal.fire('خطأ!', 'يرجى إدخال كافة البيانات', 'error');
            }
        }
    });
}