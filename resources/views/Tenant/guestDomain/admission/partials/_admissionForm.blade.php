<div class="bg-purple-100 h-full">
    <div class="px-4 sm:px-6 lg:px-8 ">
    <div class=" ">
        <div class="py-10 text-center">
            <h1 class="text-2xl capitalize text-blue-100 font-medium">{{$schoolName ?? ''}}</h1>
            <p class="text-sm text-gray-300">{{$schoolLocation ?? ''}}</p>
            <p class="text-sm text-gray-300">{{$schoolNumber ?? ''}}</p>
            <p class="text-sm text-gray-300">{{$schoolEmail ?? ''}}</p>
            <p class="text-sm text-gray-300 italic">{{$schoolWebsite ?? ''}}</p>
            <h4 class="text-md text-blue-100 font-medium">Admission Form</h4>
        </div>
    </div>
        @if($errors->any())
            <div class="mx-8 bg-red-100 p-4">
                @foreach ($errors->all() as $error)
                    <p class="text-white">
                        {!! $error !!}
                    </p>
                @endforeach
            </div>
        @endif
  <form action="{{route('storeAdmission')}}" method="post">
      @csrf
      <div class="mt-4">
          <div class="py-8 text-lg text-blue-100 regular">
              Basic Information:
          </div>
      </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label for="studentFirstName" class="block text-sm font-medium text-gray-300">First Name</label>
                <div class="mt-1">
                    <input type="text" name="studentFirstName" id="studentFirstName" value="{{old('studentFirstName')}}" class="@error('studentFirstName') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('studentFirstName')
                        <p class="text-md text-red-100">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentLastName" class="block text-sm font-medium text-gray-300">Last name</label>
                <div class="mt-1">
                    <input type="text" name="studentLastName" id="studentLastName" value="{{old('studentLastName')}}" class="@error('studentLastName') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('studentLastName')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentOtherName" class="block text-sm font-medium text-gray-300">Other name</label>
                <div class="mt-1">
                    <input type="text" name="studentOtherName" id="studentOtherName" value="{{old('studentOtherName')}}" class="@error('studentOtherName') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('studentOtherName')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentGender" class="block text-sm font-medium text-gray-300">Gender</label>
                <div class="mt-1">
                    <select name="studentGender" id="studentGender" class="@error('studentGender') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                        <option value="">-- Select Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('studentGender')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentDob" class="block text-sm font-medium text-gray-300">DOB</label>
                <div class="mt-1">
                    <input type="date" name="studentDob" value="{{old('studentDob')}}" id="studentDob" class="@error('studentDob') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                    @error('studentDob')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentReligion" class="block text-sm font-medium text-gray-300">Religion</label>
                <div class="mt-1">
                    <select name="studentReligion" id="studentReligion" class="@error('studentReligion') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                        <option value="">-- Select Religion --</option>
                        <option value="christian">Christian</option>
                        <option value="muslim">Muslim</option>
                    </select>
                    @error('studentReligion')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentBloodGroup" class="block text-sm font-medium text-gray-300">Blood Group</label>
                <div class="mt-1">
                    <input type="text" name="studentBloodGroup" value="{{old('studentBloodGroup')}}" id="studentBloodGroup" placeholder="optional" class="@error('studentBloodGroup') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                    @error('studentBloodGroup')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="studentAddress" class="block text-sm font-medium text-gray-300">Address</label>
                <div class="mt-1">
                    <input type="text" name="studentAddress" id="studentAddress" value="{{old('studentAddress')}}" class="@error('studentAddress') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('studentAddress')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
         </div>

      <div class="mt-4">
          <div class="py-8 text-lg text-blue-100 regular">
              Academic Information:
          </div>
      </div>
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
              <label for="previousSchool" class="block text-sm font-medium text-gray-300">Previous school</label>
              <div class="mt-1">
                  <input type="text" name="previousSchool" id="previousSchool" value="{{old('previousSchool')}}" class="@error('previousSchool') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                  @error('previousSchool')
                  <p class="text-md text-red-100">
                      {{$message}}
                  </p>
                  @enderror
              </div>
          </div>
          <div>
              <label for="previousClass" class="block text-sm font-medium text-gray-300">Previous class</label>
              <div class="mt-1">
                  <select name="previousClass" id="previousClass" class="@error('previousClass') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                      <option value="">-- Select Class --</option>
                      <option value="jss-one">JSS1</option>
                      <option value="jss-two">JSS2</option>
                      <option value="sss-one">SSS1</option>
                  </select>
                  @error('previousClass')
                  <p class="text-md text-red-100">
                      {{$message}}
                  </p>
                  @enderror
              </div>
          </div>
          <div>
              <label for="class" class="block text-sm font-medium text-gray-300">Class seeking admission to</label>
              <div class="mt-1">
                  <select name="class" id="class" class="@error('class') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                      <option value="">-- Select Class --</option>
                      <option value="jss-one">JSS1</option>
                      <option value="jss-two">JSS2</option>
                      <option value="sss-one">SSS1</option>
                  </select>
                  @error('class')
                  <p class="text-md text-red-100">
                      {{$message}}
                  </p>
                  @enderror
              </div>
          </div>
          <div>
              <label for="section" class="block text-sm font-medium text-gray-300">Class section</label>
              <div class="mt-1">
                  <select name="section" id="section" class="@error('section') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                      <option value="">-- Select Class Section --</option>
                      <option value="science">Science</option>
                      <option value="arts">Arts</option>
                      <option value="commercial">Commercial</option>
                  </select>
                  @error('section')
                  <p class="text-md text-red-100">
                      {{$message}}
                  </p>
                  @enderror
              </div>
          </div>
      </div>

    <div class="mt-4">
        <div class="py-8 text-lg text-blue-100 regular">
            Guardian Information:
        </div>
    </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label for="guardianName" class="block text-sm font-medium text-gray-300">Guardian name</label>
                <div class="mt-1">
                    <input type="text" name="guardianName" id="guardianName" value="{{old('guardianName')}}" class="@error('guardianName') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('guardianName')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="guardianRelationship" class="block text-sm font-medium text-gray-300">Relationship</label>
                <div class="mt-1">
                    <input type="text" name="guardianRelationship" id="guardianRelationship" value="{{old('guardianRelationship')}}" class="@error('guardianRelationship') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('guardianRelationship')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="guardianContactNumber" class="block text-sm font-medium text-gray-300">Phone number</label>
                <div class="mt-1">
                    <input type="text" name="guardianContactNumber" id="guardianContactNumber" value="{{old('guardianContactNumber')}}" class="@error('guardianContactNumber') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('guardianContactNumber')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="guardianContactEmail" class="block text-sm font-medium text-gray-300">Email</label>
                <div class="mt-1">
                    <input type="email" name="guardianContactEmail" id="guardianContactEmail" value="{{old('guardianContactEmail')}}" class="@error('guardianContactEmail') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                    @error('guardianContactEmail')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="guardianAddress" class="block text-sm font-medium text-gray-300">Address</label>
                <div class="mt-1">
                    <input type="text" name="guardianAddress" id="guardianAddress" value="{{old('guardianAddress')}}" class="@error('guardianAddress') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    @error('guardianAddress')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="guardianProfession" class="block text-sm font-medium text-gray-300">Profession</label>
                <div class="mt-1">
                    <input type="text" name="guardianProfession" id="guardianProfession" value="{{old('guardianProfession')}}" class="@error('guardianProfession') border-red-100 @else border-purple-100 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                    @error('guardianProfession')
                    <p class="text-md text-red-100">
                        {{$message}}
                    </p>
                    @enderror
                </div>
            </div>
         </div>
      <div class="mt-4">
          <div class="py-8 text-lg text-blue-100 regular">
              Extra Information:
          </div>
          <div>
              <textarea name="extraInformation" placeholder="optional" rows="3" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border"></textarea>
          </div>
      </div>
         <div class="flex justify-end py-8">
             <button type="submit" class="bg-blue-100 text-white px-6 py-2 rounded-md text-sm">
                Submit
             </button>
         </div>
  </form>
    </div>
</div>
