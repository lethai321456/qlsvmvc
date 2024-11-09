$('button.delete').click(function (e) {
	var dataUrl = $(this).attr('data-href');
	//Cập nhật giá trị cho thuộc tính href của thẻ a nằm trong thẻ có id là exampleModal
	$('#exampleModal a').attr('href', dataUrl);
});
$(".form-student-create, .form-student-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50,
			regex: /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i

		},
		birthday: {
			required: true,
		},
		gender: {
			required: true
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		name: {
			required: 'Vui lòng nhập họ và tên',
			maxlength: 'Vui lòng nhập không quá 50 ký tự',
			regex: 'Vui lòng không nhập số hoặc ký tự đặc biệt'

		},
		birthday: {
			required: 'Vui lòng chọn ngày sinh',

		},
		gender: {
			required: 'Vui lòng chọn giới tính',

		},

	}
});

$(".form-subject-create, .form-subject-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50

		},
		number_of_credit: {
			required: true,
			digits: true,
			range: [1, 10]
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		name: {
			required: 'Vui lòng nhập tên môn học',
			maxlength: 'Vui lòng nhập không quá 50 ký tự',

		},
		number_of_credit: {
			required: 'Vui lòng chọn ngày sinh',
			digits: 'Vui lòng chỉ nhập con số',
			range: 'Vui lòng nhập con số từ 1 đến 10'
		},
	}
});
$(".form-register-create").validate({
	rules: {
		// simple rule, converted to {required:true}
		student_id: {
			required: true
		},
		subject_id: {
			required: true,
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		student_id: {
			required: 'Vui lòng chọn sinh viên',
		},
		subject_id: {
			required: 'Vui lòng chọn môn học',
		},
	}
});
$(".form-register-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		score: {
			required: true,
			number: true,
			range: [0, 10]
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		score: {
			required: 'Vui lòng nhập điểm',
			number: 'Vui lòng nhập con số',
			range: 'Vui lòng nhập con số từ 0 đến 10'

		},
	}
});

$.validator.addMethod(
	"regex",
	function (value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);