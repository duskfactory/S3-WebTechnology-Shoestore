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
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
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
                response = await axios.get('https://webtech.local:8080/users', data);
            else
                response = await axios.post('https://webtech.local:8080/users/register', data);
        } catch(error) {
            console.error(error);
            location.reload();
        }

        if (response.status == 200 || response.status == 201) {
            let userData = response.data;
            sessionStorage.name = userData.name;
            sessionStorage.id = userData.id;
            location.href = "https://webtech.local/user";
        } else
            location.reload();
    }

    document.forms[0].addEventListener('submit', function { formHandler(0) });
    document.forms[1].addEventListener('submit', function { formHandler(1) });
</script>
@endsection
