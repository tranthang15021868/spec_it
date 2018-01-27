<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'txtName' => 'required|string|max:255',
            'txtNgLienQuan' => 'string', 
            'txtContent' => 'required',
            'doUuTien' => 'required',
            'boPhanIT' => 'required',
            'txtDate' => 'required|date',
            'image' => 'required|image'
        ];
    }

    public function messages() {
        return [
            'txtName.required' => 'Bạn cần nhập tên công việc',
            'txtName.string' => 'Tên phải là chuỗi',
            'txtNgLienQuan.string' => 'Tên phải là chuỗi',
            'txtContent.required' => 'Bạn cần nhập nội dung yêu cầu',
            'doUuTien.required' => 'Bạn cần chọn độ ưu tiên',
            'boPhanIT.required' => 'Bạn cần chọn Bộ phận IT',
            'txtDate.required' => 'Bạn cần nhập ngày hết hạn',
            'image.required' => 'Bạn cần up ảnh',
            'image.image' => 'Bạn cần up ảnh@@'
        ];
    }
}
