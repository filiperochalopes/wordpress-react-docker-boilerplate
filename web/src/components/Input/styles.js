import styled from "styled-components";

export default styled.div`
  position: relative;

  input {
    outline: none;
    border: none;
    border-radius: 5px;
    background: #f0f0f0;
    padding: 0.5rem 1rem;
    margin-bottom: 0.2rem;

    &::placeholder {
      color: ${(props) => props.theme.black};
    }
  }

  span {
    display: block;
    color: red;
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
  }
`;
