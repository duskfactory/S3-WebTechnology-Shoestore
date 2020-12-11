@extends('app')

@section('title', 'Login')

@section('main')
<section>
    <h1>Log In</h1>
    <form>
        <div>
            <label for="logInName">Name: </label>
            <input type="text" id="logInName" name="name" />
        </div>
        <div>
            <label for="logInPassword">Password: </label>
            <input type="password" id="logInPassword" name="password" />
        </div>
        <button type="submit">Log in</button>
    </form>
</section>
<section>
    <h1>Register</h1>
    <form>
        <div>
            <label for="registerName">Name: </label>
            <input type="text" id="registerName" name="name" />
        </div>
        <div>
            <label for="registerEmail">Email: </label>
            <input type="email" id="registerEmail" name="email" />
        </div>
        <div>
            <label for="registerPassword">Password: </label>
            <input type="password" id="registerPassword" name="password" />
        </div>
        <button type="submit">Register</button>
    </form>
</section>
@endsection

@section('scripts')
<script>
    if (sessionStorage.getItem('elegance_id') != null)
        location.href = "{{ route('profile') }}";

    const baseUrl = "https://webtech.local:8443/";
    const formDataToJson = elements => 
        [].reduce.call(elements, (data, elements) => {
            data[element.name] = element.value;
            return data
        }, {});

    async function formHandler(event, formNr) {
        event.preventDefault();
        const form = document.forms[formNr];
        const data = formDataToJson(form.elements);

        let response;
        try {
            if (formNr == 0)
                response = await axios.get(baseUrl + 'users/login', data);
            else
                response = await axios.get(baseUrl + 'users/create', data);
        } catch(error)
            location.href = "{{ route('error') }}";

        if (response.status == 200 || response.status == 201) {
            let userData = response.data;
            sessionStorage.setItem('elegance_user', userData.name);
            sessionStorage.setItem('elegance_id', userData.id);
            location.href = "{{ route('profile') }}";
        } else
            location.href = "{{ route('error') }}";
    }

    document.forms[0].addEventListener('submit', function { formHandler(0) });
    document.forms[1].addEventListener('submit', function { formHandler(1) });
</script>
@endsection
