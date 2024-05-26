import { createGlobalStyle } from "styled-components";

export const theme = {
  grey: "#7f7f7f",
  dark: "#4f4f4f",
};

export const GlobalStyles = createGlobalStyle`
  *{
    margin: 0;
    padding: 0;
    font-family: 'Raleway', sans-serif;
  }

  h1, h2{
    font-family: 'Arvo', serif;
  }

  html, body, #root{
    height: 100%;
    background: ${(props) => props.theme.dark};
    text-align: center;
  }

  main{
    max-width: 600px;
    width: 100vw;
    padding: 0 16px;
    box-sizing: border-box;
    margin: 0 auto;
  }

  h1{
    color: ${(props) => props.theme.grey};
  }

  input{
    background: ${(props) => props.theme.grey};
    color: white;
  }

  .flex {
    display: flex;
    &.space-between { justify-content: space-between }
    &.align-end { align-items: flex-end }
    &.justify-end { justify-content: flex-end }
    &.center { align-items: center }
  }
`;
